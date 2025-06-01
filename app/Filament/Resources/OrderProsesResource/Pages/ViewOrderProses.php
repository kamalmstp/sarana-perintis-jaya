<?php

namespace App\Filament\Resources\OrderProsesResource\Pages;

use App\Filament\Resources\OrderProsesResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewOrderProses extends ViewRecord
{
    protected static string $resource = OrderProsesResource::class;
    protected static bool $canCreateAnother = false;

    //customize redirect after create
    public function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    public static function getNavigationLabel(): string
    {
        return 'Informasi';
    }
}
