<?php

namespace App\Filament\Resources\TruckMaintenanceResource\Pages;

use App\Filament\Resources\TruckMaintenanceResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTruckMaintenance extends EditRecord
{
    protected static string $resource = TruckMaintenanceResource::class;

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
