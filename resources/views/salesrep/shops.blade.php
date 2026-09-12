@extends('layouts.salesrep')
@section('page-title', 'Shop List')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span><i class="fas fa-store me-2" style="color:#2d6a9f;"></i> All Shops
        <span class="badge bg-primary ms-2">{{ count($shops) }} Shops</span></span>
        <a href="{{ route('salesrep.shops.create') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus me-1"></i> Add Shop
        </a>
    </div>
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th class="px-4">#</th>
                    <th>Shop Name</th>
                    <th>Owner</th>
                    <th>Phone</th>
                    <th>Area</th>
                    <th>Address</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($shops as $shop)
                <tr>
                    <td class="px-4">{{ $loop->iteration }}</td>
                    <td><strong>{{ $shop->shop_name }}</strong></td>
                    <td>{{ $shop->owner_name }}</td>
                    <td>{{ $shop->phone }}</td>
                    <td>{{ $shop->area }}</td>
                    <td style="font-size:12px;">{{ $shop->address }}</td>
                    <td>
                        @if($shop->status == 'Active')
                            <span class="badge bg-success">Active</span>
                        @else
                            <span class="badge bg-secondary">Inactive</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center text-muted py-4">No shops found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection