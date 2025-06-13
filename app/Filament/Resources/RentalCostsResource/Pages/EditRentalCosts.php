<?php

namespace App\Filament\Resources\RentalCostsResource\Pages;

use App\Filament\Resources\RentalCostsResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditRentalCosts extends EditRecord
{
    protected static string $resource = RentalCostsResource::class;

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
