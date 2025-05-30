<?php

namespace App\Filament\Resources\OrderProsesResource\Pages;

use App\Filament\Resources\OrderProsesResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListOrderProses extends ListRecords
{
    protected static string $resource = OrderProsesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
