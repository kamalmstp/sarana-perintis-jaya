<?php

namespace App\Filament\Resources\RentalCostsResource\Pages;

use App\Filament\Resources\RentalCostsResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Components\Tab;
use Illuminate\Database\Eloquent\Builder;

class ListRentalCosts extends ListRecords
{
    protected static string $resource = RentalCostsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            //Actions\CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        return [
            'all' => Tab::make('Semua'),

            'belum' => Tab::make('Belum Diisi')
               ->modifyQueryUsing(fn (Builder $query) => 
                   $query->where('status', 'menunggu_biaya')
               ),

            'sudah' => Tab::make('Sudah Diisi')
               ->modifyQueryUsing(fn (Builder $query) => 
                   $query->where('status', 'selesai')
               ),
        ];
    }

    public function getDefaultActiveTab(): string | int | null
    {
        return 'belum';
    }
}
