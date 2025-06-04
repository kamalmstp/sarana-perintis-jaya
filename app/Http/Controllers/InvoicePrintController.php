<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;
use PDF;

class InvoicePrintController extends Controller
{
    public function download(Invoice $invoice)
    {
        $invoice->load('items.order_proses', 'order.customers');

        $pdf = PDF::loadView('pdf.invoice', [
            'invoice' => $invoice,
        ]);

        $fileName = 'Invoice-' . str_replace(['/','\\'], '_',$invoice->invoice_number) . '.pdf';
        return $pdf->download($fileName);
    }
}