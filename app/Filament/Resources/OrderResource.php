<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderResource\Pages;
use App\Filament\Resources\OrderResource\RelationManagers;
use App\Models\Order;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Order Management';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('customer_id')
                    ->label('Customer')
                    ->relationship(name: 'customers', titleAttribute:'name')
                    ->searchable()
                    ->required(),
                Forms\Components\TextInput::make('spk_number')
                    ->label('No SPK')
                    ->required()
                    ->maxLength(255),
                Forms\Components\DatePicker::make('spk_date')
                    ->label('Tanggal SPK')
                    ->required(),
                Forms\Components\Select::make('delivery_term')
                    ->label('Term Pengiriman')
                    ->options([
                        'dtd' => 'Door to Door',
                        'dtp' => 'Door to Port',
                        'ptd' => 'Port to Door',
                        'ptp' => 'Port to Port',
                      ])
                    ->required(),
                Forms\Components\TextInput::make('total_kg')
                    ->label('Quantity (Kg)')
                    ->numeric()
                    ->default(null),
                Forms\Components\TextInput::make('total_bag')
                    ->label('Quantity (Bag)')
                    ->numeric()
                    ->default(null),
                Forms\Components\Select::make('loading_location_id')
                    ->label('Lokasi Muat')
                    ->relationship(name:'locations', titleAttribute:'address')
                    ->searchable()
                    ->default(null),
                Forms\Components\Textarea::make('note')
                    ->label('Keterangan')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('customers.name')
                    ->label('Customer')
                    ->sortable(),
                Tables\Columns\TextColumn::make('spk_number')
                    ->label('No SPK')
                    ->searchable(),
                Tables\Columns\TextColumn::make('spk_date')
                    ->label('Tanggal SPK')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('delivery_term')
                    ->label('Pengiriman'),
                Tables\Columns\TextColumn::make('total_kg')
                    ->label('Quantity')
                    ->numeric(),
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
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
  
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
    
    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Infolists\Components\Group::make()
                    ->schema([
                        Infolists\Components\Section::make('Informasi Order')
                            ->schema([
                                Infolists\Components\Grid::make(2)
                                    ->schema([
                                        Infolists\Components\TextEntry::make('spk_number')
                                            ->label('Nomor SPK')
                                            ->icon('heroicon-o-users')
                                            ->listWithLineBreaks()
                                            ->placeholder('—'),

                                        Infolists\Components\TextEntry::make('item')
                                            ->label('Nama Barang')
                                            ->icon('heroicon-o-calendar')
                                            ->dateTime()
                                            ->placeholder('—'),
                                    ]),
                            ]),
                    ])
                    ->columnSpan(['lg' => 2]),
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
            'index' => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
            'view' => Pages\ViewOrder::route('/{record}'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }
}
