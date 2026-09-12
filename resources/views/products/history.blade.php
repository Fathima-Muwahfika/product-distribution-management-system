@extends('layouts.app')
@section('page-title', 'Stock History')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span>
            <i class="fas fa-history me-2" style="color:#2d6a9f;"></i>
            Stock History — <strong>{{ $product->name }}</strong>
            <span class="badge bg-secondary ms-2">{{ $product->product_code }}</span>
        </span>
        <a href="{{ route('products.show', $product) }}" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left me-1"></i> Back
        </a>
    </div>
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th class="px-4">#</th>
                    <th>Type</th>
                    <th>Quantity</th>
                    <th>Source / Reference</th>
                    <th>Notes</th>
                    <th>Done By</th>
                    <th>Date & Time</th>
                </tr>
            </thead>
            <tbody>
                @forelse($history as $log)
                <tr>
                    <td class="px-4">{{ $loop->iteration }}</td>
                    <td>
                        @if($log->type == 'Stock IN')
                            <span class="badge bg-success">↑ Stock IN</span>
                        @else
                            <span class="badge bg-danger">↓ Stock OUT</span>
                        @endif
                    </td>
                    <td><strong>{{ $log->quantity }}</strong> units</td>
                    <td>{{ $log->source ?? '—' }}</td>
                    <td>{{ $log->notes ?? '—' }}</td>
                    <td>{{ $log->user->name ?? 'System' }}</td>
                    <td>{{ $log->created_at->format('d M Y, h:i A') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center text-muted py-5">
                        <i class="fas fa-history fa-2x d-block mb-2"></i>No stock history yet.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-body">{{ $history->links() }}</div>
</div>
@endsection