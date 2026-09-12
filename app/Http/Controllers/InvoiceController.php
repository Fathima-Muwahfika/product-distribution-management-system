<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class InvoiceController extends Controller
{
    public function index(Request $request)
{
    $query = Invoice::with('shop', 'order');

    if ($request->status) {
        $query->where('payment_status', $request->status);
    }

    $invoices = $query->latest()->paginate(15);
    return view('invoices.index', compact('invoices'));
}

    public function show(Invoice $invoice)
    {
        $invoice->load('shop', 'order.orderItems.product', 'order.user');
        return view('invoices.show', compact('invoice'));
    }

    public function markAsPaid(Invoice $invoice)
    {
        $invoice->update([
            'payment_status' => 'Paid',
            'paid_date'      => now()->toDateString(),
        ]);

        ActivityLog::create([
            'user_id'     => Auth::id(),
            'action'      => 'Updated',
            'module'      => 'Invoices',
            'description' => 'Invoice ' . $invoice->invoice_number . ' marked as paid.',
            'ip_address'  => request()->ip(),
        ]);

        return back()->with('success', 'Invoice marked as paid!');
    }

    public function bulkPay(Request $request)
    {
        if ($request->invoice_ids) {
            Invoice::whereIn('id', $request->invoice_ids)
                ->where('payment_status', 'Unpaid')
                ->update([
                    'payment_status' => 'Paid',
                    'paid_date'      => now()->toDateString(),
                ]);

            ActivityLog::create([
                'user_id'     => Auth::id(),
                'action'      => 'Updated',
                'module'      => 'Invoices',
                'description' => count($request->invoice_ids) . ' invoices marked as paid in bulk.',
                'ip_address'  => request()->ip(),
            ]);

            return back()->with('success', count($request->invoice_ids) . ' invoices marked as paid!');
        }
        return back()->with('error', 'No invoices selected!');
    }

    public function downloadPdf(Invoice $invoice)
    {
        $invoice->load('shop', 'order.orderItems.product');
        $pdf = Pdf::loadView('invoices.pdf', compact('invoice'));
        return $pdf->download('Invoice-' . $invoice->invoice_number . '.pdf');
    }

    public function create()
    {
        return redirect()->route('invoices.index');
    }

    public function store(Request $request)
    {
        return redirect()->route('invoices.index');
    }

    public function edit(Invoice $invoice)
    {
        return redirect()->route('invoices.show', $invoice);
    }

    public function update(Request $request, Invoice $invoice)
    {
        return redirect()->route('invoices.show', $invoice);
    }

    public function destroy(Invoice $invoice)
    {
        $invoice->delete();
        return redirect()->route('invoices.index')
            ->with('success', 'Invoice deleted!');
    }
}