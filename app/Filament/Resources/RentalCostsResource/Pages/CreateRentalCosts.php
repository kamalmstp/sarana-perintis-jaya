<?php

namespace App\Filament\Resources\RentalCostsResource\Pages;

use App\Filament\Resources\RentalCostsResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateRentalCosts extends CreateRecord
{
    protected static string $resource = RentalCostsResource::class;
    protected static bool $canCreateAnother = false;

    //customize redirect after create
    public function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
