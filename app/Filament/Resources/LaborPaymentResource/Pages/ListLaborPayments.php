<?php

namespace App\Filament\Resources\LaborPaymentResource\Pages;

use App\Filament\Resources\LaborPaymentResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListLaborPayments extends ListRecords
{
    protected static string $resource = LaborPaymentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
