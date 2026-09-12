<?php

namespace App\Http\Controllers;

use App\Models\Delivery;
use App\Models\Order;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DeliveryController extends Controller
{
    public function index()
    {
        $deliveries = Delivery::with('order.shop')->latest()->paginate(15);
        return view('deliveries.index', compact('deliveries'));
    }

    public function show(Delivery $delivery)
    {
        $delivery->load('order.shop', 'order.orderItems.product');
        return view('deliveries.show', compact('delivery'));
    }

    public function edit(Delivery $delivery)
    {
        return view('deliveries.edit', compact('delivery'));
    }

    public function update(Request $request, Delivery $delivery)
    {
        $request->validate([
            'driver_name'   => 'nullable|string',
            'delivery_date' => 'nullable|date',
            'status'        => 'required',
            'notes'         => 'nullable|string',
        ]);

        $delivery->update($request->all());

        // Sync order status
        if ($request->status == 'Delivered') {
            $delivery->order->update(['status' => 'Delivered']);
        } elseif ($request->status == 'Out for Delivery') {
            $delivery->order->update(['status' => 'Out for Delivery']);
        }

        ActivityLog::create([
            'user_id'     => Auth::id(),
            'action'      => 'Updated',
            'module'      => 'Deliveries',
            'description' => 'Delivery for order ' . $delivery->order->order_number . ' updated to ' . $request->status,
            'ip_address'  => $request->ip(),
        ]);

        return redirect()->route('deliveries.index')
            ->with('success', 'Delivery updated successfully!');
    }

    public function create()
    {
        return redirect()->route('deliveries.index');
    }

    public function store(Request $request)
    {
        return redirect()->route('deliveries.index');
    }

    public function destroy(Delivery $delivery)
    {
        $delivery->delete();
        return redirect()->route('deliveries.index')
            ->with('success', 'Delivery record deleted!');
    }

    public function salesRepIndex()
    {
        $deliveries = Delivery::whereHas('order', function ($q) {
            $q->where('user_id', Auth::id());
        })->with('order.shop')->latest()->paginate(15);
        return view('salesrep.deliveries', compact('deliveries'));
    }
}