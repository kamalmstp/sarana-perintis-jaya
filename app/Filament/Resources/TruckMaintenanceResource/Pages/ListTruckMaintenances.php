<?php

namespace App\Filament\Resources\TruckMaintenanceResource\Pages;

use App\Filament\Resources\TruckMaintenanceResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTruckMaintenances extends ListRecords
{
    protected static string $resource = TruckMaintenanceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
