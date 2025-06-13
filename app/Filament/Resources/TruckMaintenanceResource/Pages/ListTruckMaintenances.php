<?php

namespace App\Filament\Resources\TruckMaintenanceResource\Pages;

use App\Filament\Resources\TruckMaintenanceResource;
use App\Models\Truck;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Components\Tab;
use Illuminate\Database\Eloquent\Builder;

class ListTruckMaintenances extends ListRecords
{
    protected static string $resource = TruckMaintenanceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        $truck = [];
        $data = Truck::orderBy('plate_number')->where('ownership','company')->get();
        $truck['all'] = Tab::make('Semua');
        foreach ($data as $row) {
            $truck[$row->plate_number] = Tab::make()->modifyQueryUsing(fn (Builder $query) => $query->where('truck_id', $row->id));
        }
        return $truck;
    }

    public function getDefaultActiveTab(): string | int | null
    {
        return 'all';
    }
}
