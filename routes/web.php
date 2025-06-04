<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InvoicePrintController;
use App\Models\Invoice;
use Barryvdh\DomPDF\Facade\Pdf;

Route::get('/invoices/{invoice}/pdf-preview', function (Invoice $invoice) {
    $pdf = Pdf::loadView('pdf.invoice', compact('invoice'));
    return $pdf->stream("invoice-{$invoice->id}.pdf");
})->name('invoices.pdf.preview');

Route::get('/invoice/{invoice}/pdf', [InvoicePrintController::class, 'download'])->name('invoice.pdf');

// Route::get('/', function () {
//     return view('welcome');
// });
