<?php

namespace App\Filament\Pages;

use Filament\Pages\Dashboard as BaseDashboard;
use App\Filament\Widgets\TmsStatsOverview;
use App\Filament\Widgets\TmsOrderChart;
use App\Filament\Widgets\TmsProfitChart;

class Dashboard extends BaseDashboard
{
    protected static ?string $navigationIcon = 'heroicon-o-home';
    protected static ?string $navigationLabel = 'Dashboard';
    protected static ?int $navigationSort = 1;

    public function getHeaderWidgets(): array
    {
        return [
            TmsStatsOverview::class,
            TmsOrderChart::class,
            TmsProfitChart::class,
        ];
    }
}