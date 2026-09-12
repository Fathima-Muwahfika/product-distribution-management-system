@extends('layouts.app')
@section('page-title', 'Delivery Management')

@section('content')
<div class="card">
    <div class="card-header-clean d-flex justify-content-between align-items-center">
        <div class="card-header-title">
            <i class="fas fa-truck me-2"></i>All Deliveries
        </div>
    </div>

    <div class="card-body p-0">
        <table class="clean-table">
            <thead>
                <tr>
                    <th class="px-3">#</th>
                    <th>Order No</th>
                    <th>Shop</th>
                    <th>Driver</th>
                    <th>Delivery Date</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($deliveries as $delivery)
                <tr>
                    <td class="px-3 text-muted">{{ $loop->iteration }}</td>
                    <td><span class="fw-600">{{ $delivery->order->order_number }}</span></td>
                    <td>{{ $delivery->order->shop->shop_name }}</td>
                    <td>{{ $delivery->driver_name ?? '—' }}</td>
                    <td>{{ $delivery->delivery_date ?? '—' }}</td>
                    <td>
                        @if($delivery->status == 'Delivered')
                            <span class="status-pill ok">Delivered</span>
                        @elseif($delivery->status == 'Out for Delivery')
                            <span class="status-pill blue">Out for Delivery</span>
                        @else
                            <span class="status-pill warning">Pending</span>
                        @endif
                    </td>
                    <td>
                        <div class="action-group">
                            <a href="{{ route('deliveries.show', $delivery) }}"
                                class="action-btn view" title="View">
                                <i class="fas fa-eye"></i>
                            </a>
                            <div class="action-divider"></div>
                            <a href="{{ route('deliveries.edit', $delivery) }}"
                                class="action-btn edit" title="Edit Delivery">
                                <i class="fas fa-pen"></i>
                            </a>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-5">
                        <i class="fas fa-truck fa-2x d-block mb-2 text-muted"></i>
                        <span class="text-muted">No deliveries found.</span>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="px-3 py-2">{{ $deliveries->links() }}</div>
</div>
@endsection

@section('scripts')
<style>
    .card { border:1px solid #f1f5f9; border-radius:12px; box-shadow:0 1px 6px rgba(0,0,0,0.05); }
    .card-header-clean { padding:14px 18px; border-bottom:1px solid #f1f5f9; }
    .card-header-title { font-size:13px; font-weight:600; color:#0f2744; display:flex; align-items:center; }
    .card-header-title i { color:#2d6a9f; }
    .clean-table { width:100%; border-collapse:collapse; }
    .clean-table thead tr { background:#fafbfc; }
    .clean-table thead th { padding:11px 14px; font-size:11px; font-weight:600; color:#94a3b8; text-transform:uppercase; letter-spacing:0.5px; border-bottom:1px solid #f1f5f9; white-space:nowrap; }
    .clean-table tbody td { padding:11px 14px; font-size:12.5px; color:#334155; border-bottom:1px solid #f8fafc; vertical-align:middle; }
    .clean-table tbody tr:last-child td { border-bottom:none; }
    .clean-table tbody tr:hover td { background:#fafbfd; }
    .fw-600 { font-weight:600; }
    .text-muted { color:#94a3b8 !important; font-size:12px; }
    .status-pill { padding:3px 10px; border-radius:20px; font-size:10.5px; font-weight:600; display:inline-block; }
    .status-pill.ok { background:#eafaf1; color:#27ae60; border:1px solid #c6f6d5; }
    .status-pill.blue { background:#e8f4fd; color:#2d6a9f; border:1px solid #bfdbfe; }
    .status-pill.warning { background:#fef9e7; color:#d4930a; border:1px solid #fde68a; }
    .status-pill.danger { background:#fff5f5; color:#e74c3c; border:1px solid #fecaca; }
    .action-group { display:inline-flex; align-items:center; background:#f8fafc; border:1px solid #e2e8f0; border-radius:8px; overflow:hidden; }
    .action-btn { width:32px; height:30px; display:flex; align-items:center; justify-content:center; font-size:12px; border:none; background:transparent; cursor:pointer; transition:all 0.15s; text-decoration:none; color:#64748b; padding:0; }
    .action-btn.view:hover { background:#e8f4fd; color:#2d6a9f; }
    .action-btn.edit:hover { background:#fef9e7; color:#d4930a; }
    .action-btn.delete:hover { background:#fff5f5; color:#e74c3c; }
    .action-divider { width:1px; height:18px; background:#e2e8f0; flex-shrink:0; }
    .form-control, .form-select { border:1.5px solid #e2e8f0; border-radius:8px; font-size:12.5px; }
    .form-control:focus, .form-select:focus { border-color:#2d6a9f; box-shadow:0 0 0 3px rgba(45,106,159,0.08); }
    .btn-primary { background:#0f2744; border-color:#0f2744; font-size:12.5px; }
    .btn-primary:hover { background:#2d6a9f; border-color:#2d6a9f; }
</style>
@endsection