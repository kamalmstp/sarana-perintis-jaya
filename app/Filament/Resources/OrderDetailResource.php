<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderDetailResource\Pages;
use App\Filament\Resources\OrderDetailResource\RelationManagers;
use App\Models\OrderDetail;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class OrderDetailResource extends Resource
{
    protected static ?string $model = OrderDetail::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-check';
    protected static ?string $navigationGroup = 'Order Management';
    protected static ?string $navigationLabel = 'Order (Trucking)';
    protected static ?int $navigationSort = 4;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('order_proses_id')
                    ->relationship('order_proses', 'id')
                    ->getOptionLabelFromRecordUsing(
                        fn ($record) => "DO : {$record->do_number} - PO : {$record->po_number} - SO : {$record->so_number}"
                    )
                    ->searchable()
                    ->preload()
                    ->required(),
                Forms\Components\Select::make('truck_id')
                    ->label('Truck')
                    ->relationship('trucks', 'plate_number')
                    ->searchable()
                    ->preload()
                    ->createOptionForm(fn (Form $form) => TruckResource::form($form))
                    ->required(),
                Forms\Components\Select::make('driver_id')
                    ->label('Driver')
                    ->relationship('drivers', 'name')
                    ->searchable()
                    ->preload()
                    ->createOptionForm(fn (Form $form) => DriverResource::form($form))
                    ->required(),
                Forms\Components\DatePicker::make('date_detail')
                    ->required(),
                Forms\Components\TextInput::make('bag_send')
                    ->numeric()
                    ->default(null),
                Forms\Components\TextInput::make('bag_received')
                    ->numeric()
                    ->default(null),
                Forms\Components\TextInput::make('bruto')
                    ->numeric()
                    ->default(null),
                Forms\Components\TextInput::make('tara')
                    ->numeric()
                    ->default(null),
                Forms\Components\TextInput::make('netto')
                    ->numeric()
                    ->default(null),
                Forms\Components\TextInput::make('status_detail'),
                Forms\Components\Textarea::make('note_detail')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                
                Tables\Columns\TextColumn::make('date_detail')
                    ->label('Tanggal')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('trucks.plate_number')
                    ->label('No Polisi')
                    ->sortable(),
                Tables\Columns\TextColumn::make('bag_send')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('bag_received')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('bruto')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('tara')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('netto')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('status_detail'),
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

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrderDetails::route('/'),
            'create' => Pages\CreateOrderDetail::route('/create'),
            'edit' => Pages\EditOrderDetail::route('/{record}/edit'),
        ];
    }
}
