<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: Arial, sans-serif; }
        body { padding: 30px; color: #1a2535; font-size: 13px; }

        .header { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 30px; padding-bottom: 20px; border-bottom: 3px solid #0f2744; }
        .company-name { font-size: 22px; font-weight: 700; color: #0f2744; }
        .company-sinhala { font-size: 16px; color: #2d6a9f; font-weight: 600; }
        .company-details { font-size: 11px; color: #64748b; margin-top: 5px; line-height: 1.6; }

        .invoice-title { text-align: right; }
        .invoice-title h2 { font-size: 28px; font-weight: 700; color: #0f2744; letter-spacing: 2px; }
        .invoice-number { font-size: 13px; color: #64748b; margin-top: 5px; }
        .invoice-status { display: inline-block; padding: 4px 14px; border-radius: 20px; font-size: 12px; font-weight: 600; margin-top: 8px; }
        .status-paid { background: #eafaf1; color: #27ae60; border: 1px solid #a9dfbf; }
        .status-unpaid { background: #fdedec; color: #e74c3c; border: 1px solid #f5b7b1; }

        .info-section { display: flex; justify-content: space-between; margin-bottom: 25px; }
        .info-box { width: 48%; }
        .info-box h4 { font-size: 11px; font-weight: 700; color: #94a3b8; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 8px; }
        .info-box p { font-size: 13px; color: #334155; line-height: 1.7; }
        .info-box strong { color: #0f2744; }

        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        thead tr { background: #0f2744; }
        thead th { color: white; padding: 11px 14px; font-size: 12px; font-weight: 600; text-align: left; }
        tbody tr { border-bottom: 1px solid #f1f5f9; }
        tbody tr:nth-child(even) { background: #f8fafc; }
        tbody td { padding: 10px 14px; font-size: 13px; color: #334155; }

        .totals { width: 280px; margin-left: auto; margin-bottom: 25px; }
        .total-row { display: flex; justify-content: space-between; padding: 7px 0; border-bottom: 1px solid #f1f5f9; font-size: 13px; }
        .total-row.grand { background: #0f2744; color: white; padding: 10px 14px; border-radius: 8px; font-weight: 700; font-size: 14px; margin-top: 5px; }

        .footer { margin-top: 30px; padding-top: 15px; border-top: 1px solid #e2e8f0; display: flex; justify-content: space-between; align-items: center; }
        .footer-note { font-size: 11px; color: #94a3b8; }
        .footer-thanks { font-size: 13px; font-weight: 600; color: #0f2744; }
    </style>
</head>
<body>

    <!-- Header -->
    <div class="header">
        <div>
            <div class="company-name">Kedalla Distributors</div>
            <div class="company-details">
                Hapugahayatathenna, Handessa, Kandy<br>
                Tel: 077-3737422 / 077-3737202<br>
                Email: admin@kedalla.com
            </div>
        </div>
        <div class="invoice-title">
            <h2>INVOICE</h2>
            <div class="invoice-number">{{ $invoice->invoice_number }}</div>
            <div>
                @if($invoice->payment_status == 'Paid')
                    <span class="invoice-status status-paid">PAID</span>
                @else
                    <span class="invoice-status status-unpaid">UNPAID</span>
                @endif
            </div>
        </div>
    </div>

    <!-- Info Section -->
    <div class="info-section">
        <div class="info-box">
            <h4>Bill To</h4>
            <p>
                <strong>{{ $invoice->shop->shop_name }}</strong><br>
                {{ $invoice->shop->owner_name }}<br>
                {{ $invoice->shop->address }}<br>
                {{ $invoice->shop->phone }}
            </p>
        </div>
        <div class="info-box" style="text-align:right;">
            <h4>Invoice Details</h4>
            <p>
                <strong>Invoice No:</strong> {{ $invoice->invoice_number }}<br>
                <strong>Order No:</strong> {{ $invoice->order->order_number }}<br>
                <strong>Invoice Date:</strong> {{ $invoice->invoice_date }}<br>
                @if($invoice->paid_date)
                <strong>Paid Date:</strong> {{ $invoice->paid_date }}<br>
                @endif
                <strong>Sales Rep:</strong> {{ $invoice->order->user->name ?? 'N/A' }}
            </p>
        </div>
    </div>

    <!-- Items Table -->
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Product Code</th>
                <th>Product Description</th>
                <th style="text-align:center;">Qty</th>
                <th style="text-align:right;">Unit Price (LKR)</th>
                <th style="text-align:right;">Subtotal (LKR)</th>
            </tr>
        </thead>
        <tbody>
            @foreach($invoice->order->orderItems as $item)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $item->product->product_code }}</td>
                <td>{{ $item->product->name }}</td>
                <td style="text-align:center;">{{ $item->quantity }}</td>
                <td style="text-align:right;">{{ number_format($item->unit_price, 2) }}</td>
                <td style="text-align:right;"><strong>{{ number_format($item->subtotal, 2) }}</strong></td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Totals -->
    <div class="totals">
        <div class="total-row">
            <span>Subtotal:</span>
            <span>LKR {{ number_format($invoice->total_amount, 2) }}</span>
        </div>
        <div class="total-row">
            <span>Tax (0%):</span>
            <span>LKR 0.00</span>
        </div>
        <div class="total-row grand">
            <span>TOTAL AMOUNT:</span>
            <span>LKR {{ number_format($invoice->total_amount, 2) }}</span>
        </div>
    </div>

    <!-- Footer -->
    <div class="footer">
        <div class="footer-note">
            Generated on {{ now()->format('d M Y, h:i A') }}<br>
            This is a computer-generated invoice.
        </div>
        <div class="footer-thanks">Thank you for your business!</div>
    </div>

</body>
</html>