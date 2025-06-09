<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OrderDetail;
use Barryvdh\DomPDF\Facade\Pdf;

class NotaController extends Controller
{
    public function cetak(OrderDetail $orderDetail)
    {
        $pdf = Pdf::loadView('nota.pdf', compact('orderDetail'));
        return $pdf->stream('nota.pdf');
    }
}
