<?php

namespace App\Filament\Resources;

use App\Filament\Forms\BiayaTruckingForm;
use Filament\Notifications\Notification;
use App\Filament\Resources\OrderDetailResource\Pages;
use App\Filament\Resources\OrderDetailResource\RelationManagers;
use App\Models\OrderDetail;
use App\Models\Truck;
use Filament\Forms;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Radio;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Columns\Summarizers\Sum;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use BezhanSalleh\FilamentShield\Contracts\HasShieldPermissions;
use pxlrbt\FilamentExcel\Actions\Tables\ExportAction;

class OrderDetailResource extends Resource
{
    protected static ?string $model = OrderDetail::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';
    protected static ?string $navigationGroup = 'Order Management';
    protected static ?string $navigationLabel = 'Order (Trucking)';
    protected static ?int $navigationSort = 4;

    public static function getPermissionPrefixes(): array
    {
        return [
            'view',
            'view_any',
            'create',
            'update',
            'restore',
            'restore_any',
            'replicate',
            'reorder',
            'delete',
            'delete_any',
            'force_delete',
            'force_delete_any',
        ];
    }

    public function getCombinedLabelAttribute(): string
    {
        return "DO: {$this->do_number} / PO: {$this->po_number} / SO: {$this->so_number}";
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->with(['driverCost', 'trucks', 'rentalCost.rental']);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Group::make()
                    ->schema([
                        Section::make('Order (Trucking)')
                            ->schema([

                                Forms\Components\Group::make([
                                    Forms\Components\Hidden::make('order_proses_id')
                                        ->default(fn () => request()->input('ownerRecord.id'))
                                        ->visible(fn () => request()->filled('ownerRecord')),

                                    Forms\Components\Select::make('order_proses_id')
                                        ->label('No DO/PO/SO')
                                        ->relationship(name: 'order_proses', titleAttribute: 'do_number')
                                        ->getOptionLabelFromRecordUsing(fn ($record) => $record->custom_label)
                                        ->searchable()
                                        ->preload()
                                        ->required()
                                        ->default(fn () => request()->input('ownerRecord.id'))
                                        ->visible(fn () => !request()->filled('ownerRecord')),
                                ]),

                                Fieldset::make('Trucking')
                                    ->schema([
                                        Forms\Components\DatePicker::make('date_detail')
                                            ->label('Tanggal')
                                            ->required(),

                                        Forms\Components\Select::make('truck_id')
                                            ->label('Truck')
                                            ->relationship('trucks', 'plate_number')
                                            ->preload()
                                            ->reactive()
                                            ->afterStateUpdated(function ($state, Set $set) {
                                                $ownership = Truck::find($state)?->ownership;
                                                $set('ownership', $ownership);
                                            })
                                            ->searchable()
                                            ->createOptionForm(fn (Form $form) => TruckResource::form($form))
                                            ->dehydrated()
                                            ->required(),
                                        
                                        Forms\Components\Hidden::make('ownership')
                                            ->dehydrated()
                                            ->reactive(),

                                        Forms\Components\Select::make('driver_id')
                                            ->label('Driver')
                                            ->relationship('drivers', 'name')
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
                                            ->live()
                                            ->reactive()
                                            ->default(null),

                                        Forms\Components\TextInput::make('tara')
                                            ->label('Tara')
                                            ->numeric()
                                            ->live()
                                            ->reactive()
                                            ->default(null),

                                        Forms\Components\Placeholder::make('netto')
                                            ->content(function (callable $get, callable $set) {
                                                $bruto = (float) $get('bruto');
                                                $tara = (float) $get('tara');
                                                return $bruto - $tara;
                                            }),
                                    ])
                                    ->columns(3),

                                Forms\Components\RichEditor::make('note_detail')
                                    ->label('Keterangan')
                                    ->columnSpanFull(),
                            ]),
                    ])
                    ->columnSpan(['lg' => 2]),

                Group::make()
                    ->schema([
                        Section::make('Biaya')
                            ->schema([
                                TextInput::make('uang_sangu')
                                    ->numeric()
                                    ->prefix('Rp')
                                    ->visible(fn (Get $get) => $get('ownership') === 'company')
                                    ->label('Uang Sangu'),

                                TextInput::make('uang_jalan')
                                    ->numeric()
                                    ->prefix('Rp')
                                    ->visible(fn (Get $get) => $get('ownership') === 'company')
                                    ->label('Uang Jalan'),

                                TextInput::make('uang_bbm')
                                    ->numeric()
                                    ->prefix('Rp')
                                    ->visible(fn (Get $get) => $get('ownership') === 'company')
                                    ->label('Uang BBM'),

                                TextInput::make('uang_kembali')
                                    ->numeric()
                                    ->prefix('Rp')
                                    ->visible(fn (Get $get) => $get('ownership') === 'company')
                                    ->label('Uang Kembali'),

                                TextInput::make('gaji_supir')
                                    ->numeric()
                                    ->prefix('Rp')
                                    ->visible(fn (Get $get) => $get('ownership') === 'company')
                                    ->label('Gaji Supir'),

                                TextInput::make('no_kwitansi')
                                    ->visible(fn (Get $get) => $get('ownership') === 'rental')
                                    ->label('No Kwitansi'),

                                TextInput::make('no_surat_jalan')
                                    ->visible(fn (Get $get) => $get('ownership') === 'rental')
                                    ->label('No Surat Jalan'),

                                Select::make('rental_id')
                                    ->label('Pemilik')
                                    ->relationship('rentalCost.rental', 'name')
                                    ->preload()
                                    ->searchable()
                                    ->visible(fn (Get $get) => $get('ownership') === 'rental')
                                    ->createOptionForm([
                                        TextInput::make('name')->label('Nama'),
                                        TextInput::make('npwp')->label('NPWP'),
                                    ])
                                    ->nullable(),

                                Radio::make('pph')
                                    ->label('Pajak')
                                    ->visible(fn (Get $get) => $get('ownership') === 'rental')
                                    ->options([
                                        '0.2' => 'NPWP',
                                        '0.05' => 'SKB',
                                    ]),

                                TextInput::make('tarif_rental')
                                    ->numeric()
                                    ->prefix('Rp')
                                    ->visible(fn (Get $get) => $get('ownership') === 'rental')
                                    ->label('Tarif Rental'),
                            ])
                    ])
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
                        $send = $record->bag_send ? number_format($record->bag_send, 0, '.', '.'). ' Bag' : '- Bag' ;
                        $received = $record->bag_received ? number_format($record->bag_received, 0, '.', '.') . ' Bag' : '- Bag' ;

                        return collect([$send, $received])->filter()->join('<br>');
                    })->html()
                    ->sortable(),
                Tables\Columns\TextColumn::make('bruto')
                    ->label('Berat')
                    ->formatStateUsing(function ($record){
                        $bruto = $record->bruto ? 'Bruto: '. number_format($record->bruto, 0, '.', '.') : '-' ;
                        $tara = $record->tara ? 'Tara: ' . number_format($record->tara, 0, '.', '.') : '-' ;
                        $netto = $record->netto ? 'Netto: ' . number_format($record->netto, 0, '.', '.') : '-' ;;

                        return collect([$bruto, $tara, $netto])->filter()->join('<br>');
                    })->html(),
                Tables\Columns\TextColumn::make('total_biaya')
                    ->label('Tagihan')
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
            ->filters([
                //
            ])
            ->actions([
                ActionGroup::make([
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
                    ->icon('heroicon-m-currency-dollar')
                    ->modalWidth('md')
                    ->color('primary'),

                    Action::make('cetak_nota')
                        ->label('Cetak Nota')
                        ->color('warning')
                        ->icon('heroicon-o-printer')
                        ->visible(fn ($record) =>
                            $record->trucks->ownership === "rental")
                        ->url(fn ($record) => route('nota.cetak', $record))
                        ->openUrlInNewTab(),

                    Action::make('selesaikan')
                        ->label('Selesaikan')
                        ->icon('heroicon-m-check-circle')
                        ->color('success')
                        ->visible(fn ($record) => !
                            $record->is_selesai)
                        ->requiresConfirmation()
                        ->action(function ($record){
                            $record->update([
                                'is_selesai' => true,
                                'selesai_at' => now(),
                            ]);

                            $record->updateStatusAutomatically();

                            Notification::make()
                                ->title('Order Berhasil diselesaikan')
                                ->success()
                                ->send();
                        }),

                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                ]),

            ])
            ->headerActions([
                ExportAction::make()
                    ->label('Export Excel'),
//                    ->exportFormat(\Maatwebsite\Excel\Excel::XLSX),
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
            'view' => Pages\ViewOrderDetails::route('/{record}'),
            'edit' => Pages\EditOrderDetail::route('/{record}/edit'),
        ];
    }
}
