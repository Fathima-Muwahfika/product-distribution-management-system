<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Shop;
use App\Models\Product;
use App\Models\Invoice;
use App\Models\Delivery;
use App\Models\ActivityLog;
use App\Models\StockHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    // ── ADMIN ──

    public function index(Request $request)
{
    $query = Order::with('shop', 'user');

    if ($request->status) {
        $query->where('status', $request->status);
    }
    if ($request->date) {
        $query->whereDate('order_date', $request->date);
    }

    $orders = $query->latest()->paginate(15);
    return view('orders.index', compact('orders'));
}

    public function create()
    {
        $shops    = Shop::where('status', 'Active')->get();
        $products = Product::where('stock_qty', '>', 0)->get();
        return view('orders.create', compact('shops', 'products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'shop_id'      => 'required',
            'order_date'   => 'required|date',
            'products'     => 'required|array|min:1',
            'products.*'   => 'required|exists:products,id',
            'quantities.*' => 'required|integer|min:1',
        ]);

        DB::transaction(function () use ($request) {
            // Generate order number
            $orderNumber = 'ORD-' . strtoupper(uniqid());

            $order = Order::create([
                'order_number' => $orderNumber,
                'shop_id'      => $request->shop_id,
                'user_id'      => Auth::id(),
                'order_date'   => $request->order_date,
                'status'       => 'Pending',
                'notes'        => $request->notes,
                'total_amount' => 0,
            ]);

            $total = 0;

            foreach ($request->products as $index => $productId) {
                $qty     = $request->quantities[$index];
                $product = Product::find($productId);

                if ($product && $product->stock_qty >= $qty) {
                    $subtotal = $product->mrp * $qty;
                    $total   += $subtotal;

                    OrderItem::create([
                        'order_id'   => $order->id,
                        'product_id' => $productId,
                        'quantity'   => $qty,
                        'unit_price' => $product->mrp,
                        'subtotal'   => $subtotal,
                    ]);

                    // Auto deduct stock
                    $product->decrement('stock_qty', $qty);

                    // Stock history
                    StockHistory::create([
                        'product_id' => $productId,
                        'quantity'   => $qty,
                        'type'       => 'Stock OUT',
                        'source'     => 'Order: ' . $order->order_number,
                        'user_id'    => Auth::id(),
                    ]);
                }
            }

            $order->update(['total_amount' => $total]);

            // Auto create delivery record
            Delivery::create([
                'order_id' => $order->id,
                'status'   => 'Pending',
            ]);

            // Auto create invoice
            Invoice::create([
                'invoice_number' => 'INV-' . strtoupper(uniqid()),
                'order_id'       => $order->id,
                'shop_id'        => $request->shop_id,
                'total_amount'   => $total,
                'payment_status' => 'Unpaid',
                'invoice_date'   => now()->toDateString(),
            ]);

            ActivityLog::create([
                'user_id'     => Auth::id(),
                'action'      => 'Created',
                'module'      => 'Orders',
                'description' => 'New order created: ' . $orderNumber,
                'ip_address'  => request()->ip(),
            ]);
        });

        return redirect()->route('orders.index')
            ->with('success', 'Order created successfully! Invoice and delivery record auto-generated.');
    }

    public function show(Order $order)
    {
        $order->load('shop', 'user', 'orderItems.product', 'delivery', 'invoice');
        return view('orders.show', compact('order'));
    }

    public function edit(Order $order)
    {
        return view('orders.edit', compact('order'));
    }

    public function update(Request $request, Order $order)
    {
        $order->update(['notes' => $request->notes]);
        return redirect()->route('orders.show', $order)
            ->with('success', 'Order updated!');
    }

    public function destroy(Order $order)
    {
        $order->delete();
        return redirect()->route('orders.index')
            ->with('success', 'Order deleted!');
    }

    public function updateStatus(Request $request, Order $order)
    {
        $order->update(['status' => $request->status]);

        // Update delivery status too
        if ($order->delivery) {
            if ($request->status == 'Out for Delivery') {
                $order->delivery->update(['status' => 'Out for Delivery']);
            } elseif ($request->status == 'Delivered') {
                $order->delivery->update([
                    'status'        => 'Delivered',
                    'delivery_date' => now()->toDateString(),
                ]);
            }
        }

        ActivityLog::create([
            'user_id'     => Auth::id(),
            'action'      => 'Updated',
            'module'      => 'Orders',
            'description' => 'Order ' . $order->order_number . ' status changed to ' . $request->status,
            'ip_address'  => request()->ip(),
        ]);

        return back()->with('success', 'Order status updated to ' . $request->status);
    }

    // ── SALES REP ──

    public function salesRepIndex()
    {
        $orders = Order::where('user_id', Auth::id())
            ->with('shop')->latest()->paginate(15);
        return view('salesrep-orders.index', compact('orders'));
    }

    public function salesRepCreate()
    {
        $shops    = Shop::where('status', 'Active')->get();
        $products = Product::where('stock_qty', '>', 0)->get();
        return view('salesrep-orders.create', compact('shops', 'products'));
    }

    public function salesRepStore(Request $request)
    {
        $request->validate([
            'shop_id'      => 'required',
            'order_date'   => 'required|date',
            'products'     => 'required|array|min:1',
            'products.*'   => 'required|exists:products,id',
            'quantities.*' => 'required|integer|min:1',
        ]);

        DB::transaction(function () use ($request) {
            $orderNumber = 'ORD-' . strtoupper(uniqid());

            $order = Order::create([
                'order_number' => $orderNumber,
                'shop_id'      => $request->shop_id,
                'user_id'      => Auth::id(),
                'order_date'   => $request->order_date,
                'status'       => 'Pending',
                'notes'        => $request->notes,
                'total_amount' => 0,
            ]);

            $total = 0;

            foreach ($request->products as $index => $productId) {
                $qty     = $request->quantities[$index];
                $product = Product::find($productId);

                if ($product && $product->stock_qty >= $qty) {
                    $subtotal = $product->mrp * $qty;
                    $total   += $subtotal;

                    OrderItem::create([
                        'order_id'   => $order->id,
                        'product_id' => $productId,
                        'quantity'   => $qty,
                        'unit_price' => $product->mrp,
                        'subtotal'   => $subtotal,
                    ]);

                    $product->decrement('stock_qty', $qty);

                    StockHistory::create([
                        'product_id' => $productId,
                        'quantity'   => $qty,
                        'type'       => 'Stock OUT',
                        'source'     => 'Order: ' . $order->order_number,
                        'user_id'    => Auth::id(),
                    ]);
                }
            }

            $order->update(['total_amount' => $total]);

            Delivery::create([
                'order_id' => $order->id,
                'status'   => 'Pending',
            ]);

            Invoice::create([
                'invoice_number' => 'INV-' . strtoupper(uniqid()),
                'order_id'       => $order->id,
                'shop_id'        => $request->shop_id,
                'total_amount'   => $total,
                'payment_status' => 'Unpaid',
                'invoice_date'   => now()->toDateString(),
            ]);

            ActivityLog::create([
                'user_id'     => Auth::id(),
                'action'      => 'Created',
                'module'      => 'Orders',
                'description' => Auth::user()->name . ' created order: ' . $orderNumber,
                'ip_address'  => request()->ip(),
            ]);
        });

        return redirect()->route('salesrep.orders')
            ->with('success', 'Order created successfully!');
    }

    public function salesRepShow(Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            return redirect()->route('salesrep.orders')
                ->with('error', 'Access denied.');
        }
        $order->load('shop', 'orderItems.product', 'delivery');
        return view('salesrep-orders.show', compact('order'));
    }

    public function salesRepDestroy(Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            return redirect()->route('salesrep.orders')
                ->with('error', 'Access denied.');
        }

        // Only pending orders can be removed — once it's being processed
        // or delivered, stock and invoices already depend on it.
        if ($order->status !== 'Pending') {
            return redirect()->route('salesrep.orders')
                ->with('error', 'Only pending orders can be deleted. This order is already ' . $order->status . '.');
        }

        ActivityLog::create([
            'user_id'     => Auth::id(),
            'action'      => 'Deleted',
            'module'      => 'Orders',
            'description' => Auth::user()->name . ' deleted order: ' . $order->order_number,
            'ip_address'  => request()->ip(),
        ]);

        $order->delete();

        return redirect()->route('salesrep.orders')
            ->with('success', 'Order deleted!');
    }
}