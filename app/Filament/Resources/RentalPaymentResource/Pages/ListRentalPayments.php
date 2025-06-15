<?php

namespace App\Filament\Resources\RentalPaymentResource\Pages;

use App\Filament\Resources\RentalPaymentResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListRentalPayments extends ListRecords
{
    protected static string $resource = RentalPaymentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
