<?php

namespace App\Filament\Resources\RentalPaymentResource\Pages;

use App\Filament\Resources\RentalPaymentResource;
use Filament\Resources\Pages\ViewRecord;
use Filament\Actions\Action;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;

class ViewRentalPayment extends ViewRecord
{
    protected static string $resource = RentalPaymentResource::class;

    public function hasForm(): bool
    {
        return false;
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('Cetak Kwitansi')
                ->icon('heroicon-o-printer')
                ->action(function () {
                    $payment = $this->record->load('rental', 'rentalCosts.orderDetail.trucks');

                    $pdf = Pdf::loadView('pdf.rental-kwitansi', [
                        'payment' => $payment,
                    ])->setPaper([0,0,425,709], 'landscape');
                    // ukuran 15 x 25

                    return response()->streamDownload(
                        fn () => print($pdf->output()),
                        'kwitansi-rental-' . $payment->id . '.pdf'
                    );
                })
        ];
    }

    public function getHeaderWidgetsColumns(): int | array
    {
        return 1;
    }

    public function getHeaderWidgets(): array
    {
        return [
            \App\Filament\Resources\RentalPaymentResource\Widgets\RentalPaymentViewCard::make([
                'record' => $this->record,
            ]),
        ];
    }
}