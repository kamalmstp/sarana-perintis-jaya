<?php
namespace App\Filament\Widgets;

use Filament\Widgets\LineChartWidget;
use App\Models\Order;
use Illuminate\Support\Carbon;

class TmsOrderChart extends LineChartWidget
{
    protected static ?string $heading = 'Order per Hari (7 Hari Terakhir)';
    protected static ?string $pollingInterval = null; // non polling, atau sesuaikan

    protected function getData(): array
    {
        $dates = collect();
        $counts = collect();

        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $count = Order::whereDate('created_at', $date)->count();

            $dates->push($date->format('d M'));
            $counts->push($count);
        }

        return [
            'labels' => $dates->toArray(),
            'datasets' => [
                [
                    'label' => 'Jumlah Order',
                    'data' => $counts->toArray(),
                    'borderColor' => '#3b82f6',
                    'backgroundColor' => 'rgba(59, 130, 246, 0.5)',
                    'fill' => true,
                    'tension' => 0.4,
                ],
            ],
        ];
    }
}