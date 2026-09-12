@extends('layouts.salesrep')
@section('page-title', 'My Deliveries')

@section('content')
<div class="card">
    <div class="card-header">
        <i class="fas fa-truck me-2" style="color:#2d6a9f;"></i> My Order Deliveries
    </div>
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th class="px-4">#</th>
                    <th>Order No</th>
                    <th>Shop</th>
                    <th>Driver</th>
                    <th>Delivery Date</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($deliveries as $delivery)
                <tr>
                    <td class="px-4">{{ $loop->iteration }}</td>
                    <td><strong>{{ $delivery->order->order_number }}</strong></td>
                    <td>{{ $delivery->order->shop->shop_name }}</td>
                    <td>{{ $delivery->driver_name ?? '—' }}</td>
                    <td>{{ $delivery->delivery_date ?? '—' }}</td>
                    <td>
                        @if($delivery->status == 'Delivered')
                            <span class="badge bg-success">Delivered ✅</span>
                        @elseif($delivery->status == 'Out for Delivery')
                            <span class="badge bg-primary">Out for Delivery 🚚</span>
                        @else
                            <span class="badge bg-warning text-dark">Pending ⏳</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center text-muted py-5">
                        <i class="fas fa-truck fa-2x d-block mb-2"></i>No deliveries yet.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-body">{{ $deliveries->links() }}</div>
</div>
@endsection