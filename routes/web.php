<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InvoicePrintController;
use App\Http\Controllers\NotaController;
use App\Models\Invoice;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\ExportOrderProsesController;

Route::get('/invoices/{invoice}/pdf-preview', function (Invoice $invoice) {
    $pdf = Pdf::loadView('pdf.invoice', compact('invoice'));
    return $pdf->stream("invoice-{$invoice->id}.pdf");
})->name('invoices.pdf.preview');

Route::get('/invoice/{invoice}/pdf', [InvoicePrintController::class, 'download'])->name('invoice.pdf');

Route::get('/labor-payments/{laborPayment}/receipt', [App\Http\Controllers\LaborPaymentPrintController::class, 'pdf'])
    ->name('labor-payments.receipt');

Route::get('/export/order-proses', [ExportOrderProsesController::class, 'export']);

Route::get('/nota/{orderDetail}/cetak', [NotaController::class, 'cetak'])->name('nota.cetak');
// Route::get('/', function () {
//     return view('welcome');
// });
