<?php

namespace App\Filament\Resources\TruckMaintenanceResource\Pages;

use App\Filament\Resources\TruckMaintenanceResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateTruckMaintenance extends CreateRecord
{
    protected static string $resource = TruckMaintenanceResource::class;
    protected static bool $canCreateAnother = false;

    //customize redirect after create
    public function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
