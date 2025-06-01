<?php

namespace App\Filament\Resources\TruckResource\Pages;

use App\Filament\Resources\TruckResource;
use Filament\Actions;
use App\Filament\Imports\TruckImporter;
use Filament\Resources\Pages\ListRecords;

class ListTrucks extends ListRecords
{
    protected static string $resource = TruckResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            Actions\ImportAction::make()
                ->importer(TruckImporter::class),
        ];
    }
}
