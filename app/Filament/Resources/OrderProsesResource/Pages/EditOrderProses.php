<?php

namespace App\Filament\Resources\OrderProsesResource\Pages;

use App\Filament\Resources\OrderProsesResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditOrderProses extends EditRecord
{
    protected static string $resource = OrderProsesResource::class;

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
