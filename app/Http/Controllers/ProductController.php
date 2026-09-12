<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\StockHistory;
use App\Models\StockBatch;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::query();

        if ($request->search) {
            $query->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('product_code', 'like', '%' . $request->search . '%');
        }
        if ($request->category) {
            $query->where('category', $request->category);
        }
        if ($request->source) {
            $query->where('source', $request->source);
        }
        if ($request->stock_status == 'low') {
            $query->whereColumn('stock_qty', '<=', 'min_stock_level');
        }

        $products   = $query->latest()->paginate(15);
        $categories = Product::distinct()->pluck('category');
        return view('products.index', compact('products', 'categories'));
    }

    public function create()
    {
        $categories = $this->categoryOptions();
        return view('products.create', compact('categories'));
    }

    /**
     * Builds the list of categories to show in the dropdown: the
     * starter defaults, plus every category already in use in the
     * products table (so any custom category ever typed in keeps
     * showing up for future products too), deduplicated and sorted.
     */
    private function categoryOptions(): array
    {
        $defaults = ['Broom', 'Mop', 'Brush', 'Wiper', 'Dust Pan', 'Scourer', 'Bucket'];
        $existing = Product::whereNotNull('category')
            ->where('category', '!=', '')
            ->distinct()
            ->pluck('category')
            ->toArray();

        $all = array_unique(array_merge($defaults, $existing));
        sort($all);

        return $all;
    }

    /**
     * If the "+ Add New Category..." option was chosen, use the typed
     * custom category name as the real category instead of "Other".
     */
    private function resolveCategory(Request $request): string
    {
        if ($request->category === 'Other' && $request->filled('custom_category')) {
            return trim($request->custom_category);
        }
        return $request->category;
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'            => 'required',
            'category'        => 'required',
            'custom_category' => 'required_if:category,Other',
            'carton_qty'      => 'required|integer',
            'cost_price'      => 'required|numeric',
            'mrp'             => 'required|numeric',
            'stock_qty'       => 'required|integer',
            'min_stock_level' => 'required|integer',
            'source'          => 'required',
        ]);

        $data = $request->all();
        $data['category']     = $this->resolveCategory($request);
        $data['product_code'] = $this->generateProductCode();

        $product = Product::create($data);

        // Opening stock becomes this product's first batch (Batch 1),
        // recorded at its cost price / MRP.
        if ($request->stock_qty > 0) {
            StockBatch::create([
                'product_id'    => $product->id,
                'cost_price'    => $product->cost_price,
                'mrp'           => $product->mrp,
                'quantity'      => $request->stock_qty,
                'remaining_qty' => $request->stock_qty,
                'source'        => 'Opening Stock',
                'user_id'       => Auth::id(),
            ]);

            StockHistory::create([
                'product_id' => $product->id,
                'quantity'   => $request->stock_qty,
                'type'       => 'Stock IN',
                'source'     => 'Initial Stock',
                'user_id'    => Auth::id(),
            ]);
        }

        ActivityLog::create([
            'user_id'     => Auth::id(),
            'action'      => 'Created',
            'module'      => 'Inventory',
            'description' => 'New product added: ' . $product->name . ' (' . $product->product_code . ')',
            'ip_address'  => $request->ip(),
        ]);

        return redirect()->route('products.index')
            ->with('success', 'Product added successfully! Code: ' . $product->product_code);
    }

    /**
     * Auto-generate the next unique product code, e.g. KD-0001, KD-0002...
     */
    private function generateProductCode(): string
    {
        $prefix = 'KD-';

        $last = Product::where('product_code', 'like', $prefix . '%')
            ->orderByDesc('id')
            ->first();

        $nextNumber = 1;
        if ($last) {
            $nextNumber = (int) str_replace($prefix, '', $last->product_code) + 1;
        }

        $code = $prefix . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);

        // Safety net in the rare case of a collision (e.g. manual data
        // edits) — just keep counting up until a free code is found.
        while (Product::where('product_code', $code)->exists()) {
            $nextNumber++;
            $code = $prefix . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
        }

        return $code;
    }

    public function show(Product $product)
    {
        $history = StockHistory::where('product_id', $product->id)
            ->with('user')->latest()->take(10)->get();
        $batches = $product->batches()->with('user')->latest()->get();
        return view('products.show', compact('product', 'history', 'batches'));
    }

    public function edit(Product $product)
    {
        $categories = $this->categoryOptions();
        return view('products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name'            => 'required',
            'category'        => 'required',
            'custom_category' => 'required_if:category,Other',
            'carton_qty'      => 'required|integer',
            'cost_price'      => 'required|numeric',
            'mrp'             => 'required|numeric',
            'stock_qty'       => 'required|integer',
            'min_stock_level' => 'required|integer',
            'source'          => 'required',
        ]);

        $data             = $request->except('product_code', 'custom_category');
        $data['category'] = $this->resolveCategory($request);

        $product->update($data);

        ActivityLog::create([
            'user_id'     => Auth::id(),
            'action'      => 'Updated',
            'module'      => 'Inventory',
            'description' => 'Product updated: ' . $product->name,
            'ip_address'  => $request->ip(),
        ]);

        return redirect()->route('products.index')
            ->with('success', 'Product updated successfully!');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('products.index')
            ->with('success', 'Product deleted!');
    }

    public function stockIn(Request $request, Product $product)
    {
        $request->validate([
            'quantity'   => 'required|integer|min:1',
            'source'     => 'required',
            'notes'      => 'nullable|string',
            'cost_price' => 'nullable|numeric|min:0',
            'mrp'        => 'nullable|numeric|min:0',
        ]);

        // If a new price wasn't typed in, keep using the product's
        // current price (so old behaviour still works unchanged).
        $costPrice = $request->filled('cost_price') ? $request->cost_price : $product->cost_price;
        $mrp       = $request->filled('mrp') ? $request->mrp : $product->mrp;

        $priceChanged = bccomp((string) $costPrice, (string) $product->cost_price, 2) !== 0
            || bccomp((string) $mrp, (string) $product->mrp, 2) !== 0;

        // This new stock always becomes its own batch, so it keeps its
        // own price and its own remaining quantity, separate from any
        // earlier batch(es) — even if the price didn't change, it's
        // simplest and safest to track it as a new batch too.
        StockBatch::create([
            'product_id'    => $product->id,
            'cost_price'    => $costPrice,
            'mrp'           => $mrp,
            'quantity'      => $request->quantity,
            'remaining_qty' => $request->quantity,
            'source'        => $request->source,
            'notes'         => $request->notes,
            'user_id'       => Auth::id(),
        ]);

        // Total stock shown everywhere else in the app (product list,
        // order screens, reports) is the sum of all batches.
        $product->increment('stock_qty', $request->quantity);

        // If the price changed, the product's "current" price is
        // updated to the new one — this is what shows on the product
        // list and is offered by default for future sales/orders. The
        // OLD batch above keeps recording the OLD price permanently.
        if ($priceChanged) {
            $product->cost_price = $costPrice;
            $product->mrp        = $mrp;
            $product->save();
        }

        StockHistory::create([
            'product_id' => $product->id,
            'quantity'   => $request->quantity,
            'type'       => 'Stock IN',
            'source'     => $request->source,
            'notes'      => $priceChanged
                ? trim(($request->notes ? $request->notes . ' — ' : '') . 'New batch at Rs. ' . number_format($costPrice, 2) . ' cost / Rs. ' . number_format($mrp, 2) . ' MRP')
                : $request->notes,
            'user_id'    => Auth::id(),
        ]);

        ActivityLog::create([
            'user_id'     => Auth::id(),
            'action'      => 'Stock IN',
            'module'      => 'Inventory',
            'description' => $request->quantity . ' units added to ' . $product->name . ' from ' . $request->source
                . ($priceChanged ? ' (new price batch)' : ''),
            'ip_address'  => $request->ip(),
        ]);

        $message = $priceChanged
            ? $request->quantity . ' units added as a new batch at the new price! Old stock is still kept at the old price.'
            : $request->quantity . ' units added to stock!';

        return back()->with('success', $message);
    }

    public function history(Product $product)
    {
        $history = StockHistory::where('product_id', $product->id)
            ->with('user')->latest()->paginate(15);
        return view('products.history', compact('product', 'history'));
    }

    public function salesRepIndex()
    {
        $products = Product::latest()->get();
        return view('salesrep.products', compact('products'));
    }
}