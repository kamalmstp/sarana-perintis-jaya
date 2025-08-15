<?php

namespace App\Filament\Resources\ShippingLineResource\Pages;

use App\Filament\Resources\ShippingLineResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateShippingLine extends CreateRecord
{
    protected static string $resource = ShippingLineResource::class;
    protected static bool $canCreateAnother = false;

    //customize redirect after create
    public function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
