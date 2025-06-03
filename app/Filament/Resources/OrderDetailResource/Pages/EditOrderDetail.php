<?php

namespace App\Filament\Resources\OrderDetailResource\Pages;

use App\Filament\Resources\OrderDetailResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditOrderDetail extends EditRecord
{
    protected static string $resource = OrderDetailResource::class;

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $record = $this->record;

        $ownership = $record->trucks?->ownership ?? null;

        $data['ownership'] = $ownership;

        if ($ownership === 'company' && $record->driverCost) {
            $data = array_merge($data, $record->driverCost->only([
                'uang_sangu', 'uang_kembali', 'gaji_supir', 'uang_bbm', 'uang_jalan',
            ]));
        }

        if ($ownership === 'rental' && $record->rentalCost) {
            $data = array_merge($data, $record->rentalCost->only([
                'tarif_rental',
            ]));
        }

        return $data;
    }
    protected function getHeaderActions(): array
    {
        return [
        ];
    }

    //customize redirect after create
    public function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
