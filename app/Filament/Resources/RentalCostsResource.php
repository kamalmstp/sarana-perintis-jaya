<?php

namespace App\Filament\Resources;

use App\Filament\Forms\BiayaTruckingForm;
use App\Filament\Resources\RentalCostsResource\Pages;
use App\Filament\Resources\RentalCostsResource\RelationManagers;
use App\Models\OrderDetail;
use App\Models\OrderProses;
use App\Models\RentalCosts;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Enums\ActionsPosition;
use Filament\Tables\Enums\FiltersPlacement;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Tables\Columns\BadgeColumn;
use Filament\Tables\Tables\Columns\IconColumn;
use Filament\Tables\Enums\IconPosition;

class RentalCostsResource extends Resource
{
    protected static ?string $model = OrderDetail::class;

    protected static ?string $navigationIcon = 'heroicon-o-truck';
    protected static ?string $navigationGroup = 'Finance';
    protected static ?string $label = 'Biaya Angkutan';
    protected static ?string $navigationLabel = 'Biaya Angkutan';
    protected static ?int $navigationSort = 7;

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('date_detail')
                    ->label('Tanggal')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('trucks.plate_number')
                    ->label('Truck')
                    ->formatStateUsing(function ($record){
                        $truck = $record->truck_id ? $record->trucks->plate_number : '-' ;
                        $driver = $record->driver_id ? '(' . $record->drivers->name . ')' : '-' ;
                        return collect([$truck, $driver])->filter()->join('<br>');
                    })->html()
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('order_proses.locations.name')
                    ->label('Tujuan'),
                Tables\Columns\TextColumn::make('netto')
                    ->label('Berat')
                    ->formatStateUsing(function ($record){
                        $netto = $record->netto ? number_format($record->netto, 0, '.', '.') .' Kg' : '-' ;
                        return $netto;
                    }),
                Tables\Columns\TextColumn::make('rentalCost.biaya_rental')
                    ->label('Total Biaya')
                    ->formatStateUsing(fn ($state) => 'Rp '. number_format($state, 0, ',', '.'))
                    ->sortable(),
                Tables\Columns\BadgeColumn::make('status')
                    ->label('Status')
                    ->formatStateUsing(fn (?string $state) => [
                        'pending' => 'Pending',
                        'proses' => 'Proses',
                        'menunggu_biaya' => 'Menunggu Biaya',
                        'selesai' => 'Selesai',
                    ][$state] ?? 'Tidak diketahui')
                    ->colors([
                        'primary' => 'pending',
                        'warning' => 'menunggu_biaya',
                        'success' => 'selesai',
                        'danger' => 'proses',
                    ]),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([])
            ->modifyQueryUsing(function ($query) {
                return $query->latest();
            })
            ->paginated()
            ->actions([
                Action::make('isi_biaya')
                    ->label('Biaya')
                    ->tooltip('Biaya Truck')
                    ->modalHeading('Isi Biaya Truck')
                    ->form(fn ($record) => BiayaTruckingForm::make($record))
                    ->fillForm(fn ($record) => BiayaTruckingForm::fill($record))
                    ->action(function ($data, $record) {
                        BiayaTruckingForm::save($data, $record);

                        $record->updateStatusAutomatically();
                        Notification::make()
                            ->title('Biaya Berhasil disimpan')
                            ->success()
                            ->send();
                    })
                    ->icon('heroicon-m-plus-circle')
                    ->modalWidth('md')
                    ->color('primary'),
            ])
            ->defaultSort('created_at', 'desc')
            ->headerActions([]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRentalCosts::route('/'),
        ];
    }

    public static function getModelLabel(): string
    {
        return 'Biaya Angkutan';
    }
}
