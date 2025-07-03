<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use App\Models\OrderProses;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class OrderProsesExport implements FromView
{
    public function view(): View
    {
        return view('exports.order_proses', [
            'data' => OrderProses::with(['orders.customers', 'order_detail.trucks', 'order_detail.drivers'])->get(),
        ]);
    }
}