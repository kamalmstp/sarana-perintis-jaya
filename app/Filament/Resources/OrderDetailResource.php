<?php

namespace App\Filament\Resources;

use App\Filament\Forms\BiayaTruckingForm;
use Filament\Notifications\Notification;
use App\Filament\Resources\OrderDetailResource\Pages;
use App\Filament\Resources\OrderDetailResource\RelationManagers;
use App\Models\OrderDetail;
use Filament\Forms;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\ActionGroup;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class OrderDetailResource extends Resource
{
    protected static ?string $model = OrderDetail::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';
    protected static ?string $navigationGroup = 'Order Management';
    protected static ?string $navigationLabel = 'Order (Trucking)';
    protected static ?int $navigationSort = 4;

    public function getCombinedLabelAttribute(): string
    {
        return "DO: {$this->do_number} / PO: {$this->po_number} / SO: {$this->so_number}";
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Group::make()
                    ->schema([
                        Section::make('Order (Trucking)')
                            ->schema([
                                Forms\Components\Select::make('order_proses_id')
                                ->label('No DO/PO/SO')
                                ->relationship('order_proses', 'id')
                                ->options(function(){
                                    return \App\Models\OrderProses::with('orders.customers')->get()->mapWithKeys(
                                        fn ($order) => [
                                            $order->id => "{$order->orders->customers->name} - DO: {$order->do_number} / PO: {$order->po_number} / SO: {$order->so_number}",
                                        ]
                                    );
                                })
                                ->searchable()
                                ->preload()
                                ->required(),

                                Fieldset::make('Trucking')
                                ->schema([
                                    Forms\Components\DatePicker::make('date_detail')
                                    ->label('Tanggal')
                                    ->required(),
                                    Forms\Components\Select::make('truck_id')
                                    ->label('Truck')
                                    ->relationship('trucks','plate_number')
                                    ->preload()
                                    ->searchable()
                                    ->createOptionForm(fn (Form $form) => TruckResource::form($form))
                                    ->default(null),
                                    Forms\Components\Select::make('driver_id')
                                    ->label('Driver')
                                    ->relationship('drivers','name')
                                    ->preload()
                                    ->searchable()
                                    ->createOptionForm(fn (Form $form) => DriverResource::form($form))
                                    ->default(null),
                                ]),

                                Fieldset::make('Pengiriman')
                                ->schema([
                                    Forms\Components\TextInput::make('bag_send')
                                        ->label('Kirim')
                                        ->suffix('Bag')
                                        ->numeric()
                                        ->default(null),
                                    
                                    Forms\Components\TextInput::make('bag_received')
                                        ->label('Terima')
                                        ->suffix('Bag')
                                        ->numeric()
                                        ->default(null),
                                ]),

                                Fieldset::make('Berat')
                                ->schema([
                                    Forms\Components\TextInput::make('bruto')
                                        ->label('Bruto')
                                        ->numeric()
                                        ->reactive()
                                        ->default(null),
                                    
                                    Forms\Components\TextInput::make('tara')
                                        ->label('Tara')
                                        ->numeric()
                                        ->reactive()
                                        ->default(null),
                                    
                                    Forms\Components\TextInput::make('netto')
                                        ->label('Netto')
                                        ->numeric()
                                        ->dehydrated()
                                        ->default(fn (callable $get) => $get('bruto') - $get('tara'))
                                        ->reactive()
                                        ->disabled(),
                                        // ->afterStateHydrated(function (callable $get, callable $set){
                                        //     $set('netto', (float) $get('bruto') - (float) $get('tara'));
                                        // }),
                                ])
                                ->columns(3),

                                Forms\Components\RichEditor::make('note_detail')
                                ->label('Keterangan')
                                ->columnSpanFull(),
                                
                            ]),
                    ])
                    ->columnSpan(['lg' => 2]),
            ])
            ->columns(3);
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
                    ->label('Qty')
                    ->formatStateUsing(function ($record){
                        $send = $record->bag_send ? number_format($record->bag_send, 0, '.', '.'). 'Bag' : '- Bag' ;
                        $received = $record->bag_received ? number_format($record->bag_received, 0, '.', '.') . ' Bag' : '- Bag' ;

                        return collect([$send, $received])->filter()->join('<br>');
                    })->html()
                    ->sortable(),
                Tables\Columns\TextColumn::make('bruto')
                    ->label('Berat')
                    ->formatStateUsing(function ($record){
                        $bruto = $record->bruto ? 'Bruto: '. number_format($record->bruto, 0, '.', '.') : '-' ;
                        $tara = $record->tara ? 'Tara: ' . number_format($record->tara, 0, '.', '.') : '-' ;
                        $netto = 'Netto: ' .($record->bruto - $record->tara);

                        return collect([$bruto, $tara, $netto])->filter()->join('<br>');
                    })->html(),
//                Tables\Columns\TextColumn::make('status_detail'),
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
                ActionGroup::make([
                    Action::make('isi_biaya')
                    ->label('Isi Biaya')
                    ->tooltip('Isi Biaya')
                    ->modalHeading('Isi Biaya Truck')
                    ->form(fn ($record) => BiayaTruckingForm::make($record))
                    ->fillForm(fn ($record) => BiayaTruckingForm::fill($record))
                    ->action(function ($data, $record) {
                        BiayaTruckingForm::save($data, $record);

                        Notification::make()
                            ->title('Biaya Berhasil disimpan')
                            ->success()
                            ->send();
                    })
                    ->icon('heroicon-m-currency-dollar')
                    ->modalWidth('md')
                    ->color('primary'),

                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                ]),

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
