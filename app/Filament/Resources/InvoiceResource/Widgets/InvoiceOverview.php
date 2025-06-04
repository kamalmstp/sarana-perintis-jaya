<?php

namespace App\Filament\Resources\InvoiceResource\Widgets;

use Filament\Widgets\Widget;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;
use Illuminate\Support\Carbon;

class InvoiceOverview extends BaseWidget
{
    public $record;

    protected function getCards(): array
    {
        $invoice = $this->record;

        return [
            Card::make('Nomor Invoice', $invoice->invoice_number),
            Card::make('Tanggal Invoice', Carbon::parse($invoice->invoice_date)->translatedFormat('d F Y')),
            Card::make('Customer', $invoice->customer_name),
            Card::make('Status', ucfirst($invoice->status)),
            Card::make('Total', 'Rp ' . number_format($invoice->total_amount, 0, ',', '.')),
            Card::make('Jatuh Tempo', Carbon::parse($invoice->due_date)->translatedFormat('d F Y')),
        ];
    }
}
