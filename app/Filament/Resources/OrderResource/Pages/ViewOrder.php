<?php

namespace App\Filament\Resources\OrderResource\Pages;

use App\Filament\Resources\OrderResource;
use Filament\Actions;
use Filament\Pages\SubNavigationPosition;
use Filament\Resources\Pages\ViewRecord;

class ViewOrder extends ViewRecord
{
    protected static string $resource = OrderResource::class;
    protected static bool $canCreateAnother = false;
    protected static SubNavigationPosition $subNavigationPosition = SubNavigationPosition::Top;

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
