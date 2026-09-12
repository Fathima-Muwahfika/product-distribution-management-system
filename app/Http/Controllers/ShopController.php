<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use App\Models\Invoice;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ShopController extends Controller
{
    public function index(Request $request)
{
    $query = Shop::withCount('orders')
        ->withSum('invoices', 'total_amount');

    if ($request->search) {
        $query->where(function($q) use ($request) {
            $q->where('shop_name', 'like', '%' . $request->search . '%')
              ->orWhere('area', 'like', '%' . $request->search . '%')
              ->orWhere('owner_name', 'like', '%' . $request->search . '%');
        });
    }

    if ($request->status) {
        $query->where('status', $request->status);
    }

    $shops = $query->latest()->paginate(15);
    return view('shops.index', compact('shops'));
}

    public function create()
    {
        return view('shops.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'shop_name'  => 'required',
            'owner_name' => 'required',
            'phone'      => 'required',
            'address'    => 'required',
            'area'       => 'required',
        ]);

        $shop = Shop::create($request->all());

        ActivityLog::create([
            'user_id'     => Auth::id(),
            'action'      => 'Created',
            'module'      => 'Shops',
            'description' => 'New shop added: ' . $shop->shop_name,
            'ip_address'  => $request->ip(),
        ]);

        return redirect()->route('shops.index')
            ->with('success', 'Shop added successfully!');
    }

    public function show(Shop $shop)
    {
        $orders          = $shop->orders()->with('user')->latest()->paginate(10);
        $totalOrders     = $shop->orders()->count();
        $totalPaid       = $shop->invoices()->where('payment_status', 'Paid')->sum('total_amount');
        $totalUnpaid     = $shop->invoices()->where('payment_status', 'Unpaid')->sum('total_amount');
        $overdueInvoices = $shop->invoices()
            ->where('payment_status', 'Unpaid')
            ->where('invoice_date', '<=', now()->subDays(30)->toDateString())
            ->count();

        return view('shops.show', compact(
            'shop', 'orders', 'totalOrders',
            'totalPaid', 'totalUnpaid', 'overdueInvoices'
        ));
    }

    public function edit(Shop $shop)
    {
        return view('shops.edit', compact('shop'));
    }

    public function update(Request $request, Shop $shop)
    {
        $request->validate([
            'shop_name'  => 'required',
            'owner_name' => 'required',
            'phone'      => 'required',
            'address'    => 'required',
            'area'       => 'required',
        ]);

        $shop->update($request->all());

        ActivityLog::create([
            'user_id'     => Auth::id(),
            'action'      => 'Updated',
            'module'      => 'Shops',
            'description' => 'Shop updated: ' . $shop->shop_name,
            'ip_address'  => $request->ip(),
        ]);

        return redirect()->route('shops.index')
            ->with('success', 'Shop updated successfully!');
    }

    public function destroy(Shop $shop)
    {
        $name = $shop->shop_name;
        $shop->delete();

        ActivityLog::create([
            'user_id'     => Auth::id(),
            'action'      => 'Deleted',
            'module'      => 'Shops',
            'description' => 'Shop deleted: ' . $name,
            'ip_address'  => request()->ip(),
        ]);

        return redirect()->route('shops.index')
            ->with('success', 'Shop deleted successfully!');
    }

    public function salesRepIndex()
{
    $shops = Shop::latest()->get();
    return view('salesrep.shops', compact('shops'));
}

public function salesRepCreate()
{
    return view('salesrep.shops-create');
}

public function salesRepStore(Request $request)
{
    $request->validate([
        'shop_name'  => 'required',
        'owner_name' => 'required',
        'phone'      => 'required',
        'address'    => 'required',
        'area'       => 'required',
    ]);

    $shop = Shop::create([
        'shop_name'    => $request->shop_name,
        'owner_name'   => $request->owner_name,
        'phone'        => $request->phone,
        'address'      => $request->address,
        'area'         => $request->area,
        'credit_limit' => $request->credit_limit ?? 0,
        'status'       => 'Active',
    ]);

    ActivityLog::create([
        'user_id'     => Auth::id(),
        'action'      => 'Created',
        'module'      => 'Shops',
        'description' => Auth::user()->name . ' added new shop: ' . $shop->shop_name,
        'ip_address'  => $request->ip(),
    ]);

    return redirect()->route('salesrep.shops')
        ->with('success', 'Shop added successfully!');
}
}