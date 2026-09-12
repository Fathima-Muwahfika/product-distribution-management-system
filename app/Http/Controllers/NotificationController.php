<?php

namespace App\Http\Controllers;

use App\Models\SystemNotification;
use App\Models\Product;
use App\Models\Invoice;
use App\Models\Delivery;

class NotificationController extends Controller
{
    public function index()
    {
        // Generate notifications
        $this->generateNotifications();

        $notifications = SystemNotification::latest()->paginate(15);
        $unreadCount   = SystemNotification::where('is_read', false)->count();

        return view('notifications', compact('notifications', 'unreadCount'));
    }

    public function markRead($id)
    {
        SystemNotification::find($id)->update(['is_read' => true]);
        return back()->with('success', 'Notification marked as read!');
    }

    public function readAll()
    {
        SystemNotification::where('is_read', false)->update(['is_read' => true]);
        return back()->with('success', 'All notifications marked as read!');
    }

    private function generateNotifications()
    {
        // ── Low Stock ──
        $lowStock = Product::whereColumn('stock_qty', '<=', 'min_stock_level')->get();
        foreach ($lowStock as $product) {
            // Check if notification exists — read OR unread
            $exists = SystemNotification::where('title', 'Low Stock: ' . $product->name)
                ->whereDate('created_at', today())
                ->exists();
            if (!$exists) {
                SystemNotification::create([
                    'title'   => 'Low Stock: ' . $product->name,
                    'message' => $product->name . ' has only ' . $product->stock_qty . ' units left. Minimum level is ' . $product->min_stock_level . '.',
                    'type'    => 'danger',
                    'module'  => 'inventory',
                    'is_read' => false,
                ]);
            }
        }

        // ── Overdue Invoices ──
        $overdue = Invoice::where('payment_status', 'Unpaid')
            ->where('invoice_date', '<=', now()->subDays(30))
            ->with('shop')
            ->get();
        foreach ($overdue as $invoice) {
            $exists = SystemNotification::where('title', 'Overdue Invoice: ' . $invoice->invoice_number)
                ->exists();
            if (!$exists) {
                SystemNotification::create([
                    'title'   => 'Overdue Invoice: ' . $invoice->invoice_number,
                    'message' => 'Invoice ' . $invoice->invoice_number . ' for ' . $invoice->shop->shop_name . ' is overdue. Amount: LKR ' . number_format($invoice->total_amount, 2),
                    'type'    => 'warning',
                    'module'  => 'invoices',
                    'is_read' => false,
                ]);
            }
        }

        // ── Pending Deliveries ──
        $pending = Delivery::where('status', 'Pending')
            ->with('order.shop')
            ->get();
        foreach ($pending as $delivery) {
            $exists = SystemNotification::where('title', 'Pending Delivery: ' . $delivery->order->order_number)
                ->exists();
            if (!$exists) {
                SystemNotification::create([
                    'title'   => 'Pending Delivery: ' . $delivery->order->order_number,
                    'message' => 'Order ' . $delivery->order->order_number . ' for ' . $delivery->order->shop->shop_name . ' is pending delivery.',
                    'type'    => 'info',
                    'module'  => 'deliveries',
                    'is_read' => false,
                ]);
            }
        }
    }
}