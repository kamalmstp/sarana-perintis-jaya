<?php

namespace App\Filament\Resources\LaborPaymentResource\Pages;

use App\Filament\Resources\LaborPaymentResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditLaborPayment extends EditRecord
{
    protected static string $resource = LaborPaymentResource::class;

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
