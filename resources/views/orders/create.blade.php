@extends('layouts.app')
@section('page-title', 'Create New Order')

@section('content')
<div class="card">
    <div class="card-header">
        <i class="fas fa-plus me-2" style="color:#2d6a9f;"></i> Create New Order
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('orders.store') }}" id="orderForm">
            @csrf
            <div class="row g-3 mb-4">
                <div class="col-md-4">
                    <label class="form-label">Select Shop *</label>
                    <select name="shop_id" class="form-select @error('shop_id') is-invalid @enderror" required>
                        <option value="">-- Select Shop --</option>
                        @foreach($shops as $shop)
                            <option value="{{ $shop->id }}" {{ old('shop_id') == $shop->id ? 'selected' : '' }}>
                                {{ $shop->shop_name }} — {{ $shop->area }}
                            </option>
                        @endforeach
                    </select>
                    @error('shop_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-3">
                    <label class="form-label">Order Date *</label>
                    <input type="date" name="order_date" class="form-control" value="{{ old('order_date', date('Y-m-d')) }}" required>
                </div>
                <div class="col-md-5">
                    <label class="form-label">Notes</label>
                    <input type="text" name="notes" class="form-control" placeholder="Optional notes..." value="{{ old('notes') }}">
                </div>
            </div>

            <!-- Product Selection -->
            <div class="mb-3">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <label class="form-label fw-bold mb-0">
                        <i class="fas fa-box me-2 text-primary"></i>Add Products
                    </label>
                    <button type="button" class="btn btn-sm btn-outline-primary" id="addRow">
                        <i class="fas fa-plus me-1"></i> Add Product Row
                    </button>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered" id="productTable">
                        <thead class="table-light">
                            <tr>
                                <th style="width:45%">Product</th>
                                <th style="width:15%">Stock</th>
                                <th style="width:15%">Price (MRP)</th>
                                <th style="width:15%">Quantity</th>
                                <th style="width:10%">Remove</th>
                            </tr>
                        </thead>
                        <tbody id="productRows">
                            <tr class="product-row">
                                <td>
                                    <select name="products[]" class="form-select form-select-sm product-select" required onchange="updateProductInfo(this)">
                                        <option value="">-- Select Product --</option>
                                        @foreach($products as $product)
                                            <option value="{{ $product->id }}"
                                                data-stock="{{ $product->stock_qty }}"
                                                data-price="{{ $product->mrp }}">
                                                {{ $product->product_code }} — {{ $product->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </td>
                                <td><span class="stock-display text-muted" style="font-size:13px;">—</span></td>
                                <td><span class="price-display text-muted" style="font-size:13px;">—</span></td>
                                <td>
                                    <input type="number" name="quantities[]" class="form-control form-control-sm qty-input" min="1" value="1" required>
                                </td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-sm btn-danger remove-row" disabled>
                                        <i class="fas fa-times"></i>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Total -->
            <div class="d-flex justify-content-between align-items-center mt-3 p-3" style="background:#f8fafc;border-radius:12px;border:1px solid #e2e8f0;">
                <div style="font-size:14px;font-weight:600;color:#475569;">Estimated Total:</div>
                <div style="font-size:20px;font-weight:700;color:#0f2744;">LKR <span id="totalAmount">0.00</span></div>
            </div>

            <div class="mt-4 d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-1"></i> Create Order
                </button>
                <a href="{{ route('orders.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    const productsData = @json($products->keyBy('id'));

    function updateProductInfo(select) {
        const row = select.closest('tr');
        const productId = select.value;
        if (productId && productsData[productId]) {
            const product = productsData[productId];
            row.querySelector('.stock-display').innerHTML = '<span class="badge ' + (product.stock_qty > 10 ? 'bg-success' : 'bg-danger') + '">' + product.stock_qty + '</span>';
            row.querySelector('.price-display').textContent = 'LKR ' + parseFloat(product.mrp).toFixed(2);
            row.querySelector('.qty-input').max = product.stock_qty;
        } else {
            row.querySelector('.stock-display').textContent = '—';
            row.querySelector('.price-display').textContent = '—';
        }
        calculateTotal();
    }

    function calculateTotal() {
        let total = 0;
        document.querySelectorAll('.product-row').forEach(row => {
            const select = row.querySelector('.product-select');
            const qty    = parseInt(row.querySelector('.qty-input').value) || 0;
            const productId = select.value;
            if (productId && productsData[productId]) {
                total += productsData[productId].mrp * qty;
            }
        });
        document.getElementById('totalAmount').textContent = total.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ',');
    }

    document.getElementById('addRow').addEventListener('click', function () {
        const tbody = document.getElementById('productRows');
        const firstRow = tbody.querySelector('.product-row');
        const newRow = firstRow.cloneNode(true);
        newRow.querySelector('.product-select').value = '';
        newRow.querySelector('.stock-display').textContent = '—';
        newRow.querySelector('.price-display').textContent = '—';
        newRow.querySelector('.qty-input').value = 1;
        newRow.querySelector('.remove-row').disabled = false;
        newRow.querySelector('.product-select').addEventListener('change', function() { updateProductInfo(this); });
        newRow.querySelector('.qty-input').addEventListener('input', calculateTotal);
        newRow.querySelector('.remove-row').addEventListener('click', function() {
            newRow.remove();
            calculateTotal();
        });
        tbody.appendChild(newRow);
    });

    document.querySelector('.product-select').addEventListener('change', function() { updateProductInfo(this); });
    document.querySelector('.qty-input').addEventListener('input', calculateTotal);
</script>
@endsection