<?php

namespace App\Http\Controllers;

use App\Models\LaborPayment;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class LaborPaymentPrintController extends Controller
{
    /**
     * Menampilkan kwitansi pembayaran buruh dalam bentuk PDF.
     */
    public function pdf(LaborPayment $laborPayment)
    {
        // Load relasi detail dan orderProses
        $laborPayment->load('details.orderProses');

        // Render PDF menggunakan Blade view dari folder "nota"
        return Pdf::loadView('nota.labor-payment', [
            'payment' => $laborPayment,
        ])->stream("Kwitansi-Buruh-{$laborPayment->payment_number}.pdf");
    }
}