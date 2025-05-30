<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderProsesResource\Pages;
use App\Filament\Resources\OrderProsesResource\RelationManagers;
use App\Models\OrderProses;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class OrderProsesResource extends Resource
{
    protected static ?string $model = OrderProses::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Order Management';
    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('order_id')
                    ->label('No SPK')
                    ->relationship(name:'orders', titleAttribute:'spk_number')
                    ->searchable()
                    ->required(),
                Forms\Components\TextInput::make('do_number')
                    ->label('No DO')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('po_number')
                    ->label('No PO')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('so_number')
                    ->label('No SO')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('item_proses')
                    ->label('Nama Barang')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('total_kg_proses')
                    ->label('Quantity (Kg)')
                    ->numeric()
                    ->default(null),
                Forms\Components\TextInput::make('total_bag_proses')
                    ->label('Quantity (Bag)')
                    ->numeric()
                    ->default(null),
                Forms\Components\Select::make('delivery_location_id')
                    ->label('Lokasi Tujuan')
                    ->relationship(name:'locations', titleAttribute:'address')
                    ->required(),
                Forms\Components\Select::make('type_proses')
                    ->label('Proses')
                    ->options([
                        'gudang' => 'Gudang',
                        'kapal' => 'Kapal',
                        'Container' => 'Container'
                      ])
                    ->required(),
                Forms\Components\TextInput::make('tarif')
                    ->label('Tarif')
                    ->numeric()
                    ->default(null),
                Forms\Components\Select::make('operation_proses')
                    ->label('Container Proses')
                    ->options([
                        'bongkar' => 'Bongkar',
                        'teruskan' => 'Teruskan'
                      ])
                    ->required(),
                Forms\Components\TextInput::make('total_container_proses')
                    ->label('Jumlah Container')
                    ->numeric()
                    ->default(null),
                Forms\Components\TextInput::make('vessel_name_proses')
                    ->label('Nama Kapal')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\Textarea::make('note_proses')
                    ->label('Keterangan')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('order_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('do_number')
                    ->searchable(),
                Tables\Columns\TextColumn::make('item_proses')
                    ->searchable(),
                Tables\Columns\TextColumn::make('total_kg_proses')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('delivery_location_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('invoice_status'),
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
            'index' => Pages\ListOrderProses::route('/'),
            'create' => Pages\CreateOrderProses::route('/create'),
            'edit' => Pages\EditOrderProses::route('/{record}/edit'),
        ];
    }
}
