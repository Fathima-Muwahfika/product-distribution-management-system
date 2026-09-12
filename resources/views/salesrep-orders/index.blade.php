@extends('layouts.salesrep')
@section('page-title', 'My Orders')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span><i class="fas fa-clipboard-list me-2" style="color:#2d6a9f;"></i>My Orders</span>
        <a href="{{ route('salesrep.orders.create') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus me-1"></i> New Order
        </a>
    </div>
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th class="px-4">Order No</th>
                    <th>Shop</th>
                    <th>Date</th>
                    <th>Amount</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                <tr>
                    <td class="px-4"><strong>{{ $order->order_number }}</strong></td>
                    <td>{{ $order->shop->shop_name }}</td>
                    <td>{{ $order->order_date }}</td>
                    <td><strong>LKR {{ number_format($order->total_amount, 2) }}</strong></td>
                    <td>
                        @if($order->status == 'Pending')
                            <span class="badge bg-warning text-dark">Pending</span>
                        @elseif($order->status == 'Processing')
                            <span class="badge bg-info text-white">Processing</span>
                        @elseif($order->status == 'Out for Delivery')
                            <span class="badge bg-primary">Out for Delivery</span>
                        @elseif($order->status == 'Delivered')
                            <span class="badge bg-success">Delivered</span>
                        @endif
                    </td>
                    <td>
                        <div class="action-group">
                            <a href="{{ route('salesrep.orders.show', $order) }}" class="action-btn view" title="View">
                                <i class="fas fa-eye"></i>
                            </a>
                            @if($order->status === 'Pending')
                                <div class="action-divider"></div>
                                <form action="{{ route('salesrep.orders.destroy', $order) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this order?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="action-btn delete" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center text-muted py-5">
                        <i class="fas fa-clipboard fa-2x d-block mb-2"></i>
                        No orders yet.
                        <a href="{{ route('salesrep.orders.create') }}">Create your first order!</a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-body">{{ $orders->links() }}</div>
</div>

<style>
    .action-group {
        display: inline-flex;
        align-items: center;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        overflow: hidden;
    }
    .action-btn {
        width: 32px;
        height: 30px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
        border: none;
        background: transparent;
        cursor: pointer;
        transition: all 0.15s;
        text-decoration: none;
        color: #64748b;
        padding: 0;
    }
    .action-btn.view:hover { background: #e8f4fd; color: #2d6a9f; }
    .action-btn.delete:hover { background: #fff5f5; color: #e74c3c; }
    .action-divider { width: 1px; height: 18px; background: #e2e8f0; flex-shrink: 0; }
</style>
@endsection