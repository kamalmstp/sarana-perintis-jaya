<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TruckMaintenanceResource\Pages;
use App\Filament\Resources\TruckMaintenanceResource\RelationManagers;
use App\Models\TruckMaintenance;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TruckMaintenanceResource extends Resource
{
    protected static ?string $model = TruckMaintenance::class;

    protected static ?string $navigationIcon = 'heroicon-o-wrench-screwdriver';
    protected static ?string $navigationGroup = 'Order Management';
    protected static ?string $navigationLabel = 'Truck Service';
    protected static ?int $navigationSort = 5;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Nama Pengeluaran')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('truck_id')
                    ->label('No Polisi')
                    ->relationship('trucks','plate_number')
                    ->searchable()
                    ->preload()
                    ->createOptionForm(fn (Form $form) => TruckResource::form($form))
                    ->required(),
                Forms\Components\DatePicker::make('date')
                    ->label('Tanggal')
                    ->required(),
                Forms\Components\TextInput::make('qty')
                    ->label('Jumlah')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('price')
                    ->label('Harga')
                    ->required()
                    ->numeric()
                    ->prefix('Rp'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('date')
                    ->label('Tanggal')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama Item')
                    ->searchable(),
                Tables\Columns\TextColumn::make('trucks.plate_number')
                    ->label('No Polisi')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('qty')
                    ->label('Jumlah')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('price')
                    ->label('Harga')
                    ->formatStateUsing(fn ($state) => 'Rp '. number_format($state, 0, ',', '.'))
                    ->sortable(),
                Tables\Columns\TextColumn::make('jumlah')
                    ->label('Total')
                    ->getStateUsing(function($record) {
                            $tot = $record->price * $record->qty;
                            return "Rp ".number_format($tot, 0, ',', '.'); // Rumus perkalian
                        })
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
   Tables\Actions\DeleteAction::make(),

            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
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
            'index' => Pages\ListTruckMaintenances::route('/'),
            'create' => Pages\CreateTruckMaintenance::route('/create'),
            'edit' => Pages\EditTruckMaintenance::route('/{record}/edit'),
        ];
    }
}
