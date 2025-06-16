<?php

namespace App\Filament\Resources\LaborPaymentResource\Pages;

use App\Filament\Resources\LaborPaymentResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateLaborPayment extends CreateRecord
{
    protected static string $resource = LaborPaymentResource::class;
    protected static bool $canCreateAnother = false;

    //customize redirect after create
    public function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
