<?php

namespace App\Filament\Resources\OrderDetailResource\Pages;

use App\Filament\Resources\OrderDetailResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use App\Models\OrderDetail;

class ViewOrderDetails extends ViewRecord
{
    protected static string $resource = OrderDetailResource::class;
    protected static bool $canCreateAnother = false;

    //customize redirect after create
    public function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('cetak_nota')
                ->label('Cetak Nota')
                ->icon('heroicon-o-printer')
                ->url(fn (OrderDetail $record) => route('nota.cetak', $record)) // ganti dengan route kamu
                ->openUrlInNewTab()
                ->visible(fn (OrderDetail $record) =>
                    $record->is_selesai === true &&
                    $record->rentalCost->tarif_rental !== null
                ),
        ];
    }
}
