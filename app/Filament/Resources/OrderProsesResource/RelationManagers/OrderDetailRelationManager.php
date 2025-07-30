<?php

namespace App\Filament\Resources\OrderProsesResource\RelationManagers;

use App\Models\{OrderDetail, Truck, OrderProses};
use Filament\Forms;
use Filament\Forms\{Get, Set, Form};
use Filament\Forms\Components\{Group, Section, Fieldset, Hidden, Radio, TextInput, Select};
use Filament\Resources\RelationManagers\RelationManager;
use App\Filament\Resources\OrderDetailResource;
use Filament\Tables\Actions\{Action, ActionGroup};
use App\Filament\Resources\{TruckResource, DriverResource};
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Infolists\Infolist;
use Filament\Notifications\Notification;

class OrderDetailRelationManager extends RelationManager
{
    protected static string $relationship = 'order_detail';
    protected static ?string $title = 'Truck';
    protected static ?string $label = 'Truck';
    protected static ?string $pluralLabel = 'Truck';
    

    public function form(Form $form): Form
    {
        $orderProses = $this->getOwnerRecord();

        $isContainerForward = $orderProses?->type_proses === 'container'
            && $orderProses?->operation_proses === 'teruskan';

        return $form
            ->schema([
                Group::make()
                    ->schema([
                        Section::make('Order (Trucking)')
                            ->schema([
                                Forms\Components\Group::make([
                                    Forms\Components\Select::make('order_proses_id')
                                        ->label('No DO/PO/SO')
                                        ->options(
                                            OrderProses::all()->pluck('custom_label', 'id')
                                        )
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

                                ...(!$isContainerForward ? [
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
                                                ->default(0),

                                            Forms\Components\Placeholder::make('netto')
                                                ->content(function (callable $get, callable $set) {
                                                    $bruto = (float) $get('bruto');
                                                    $tara = (float) $get('tara');
                                                    return $bruto - $tara;
                                                }),
                                        ])
                                        ->columns(3),
                                ] : []),

                                ...($isContainerForward ? [
                                    Fieldset::make('Container')
                                    ->schema([
                                        TextInput::make('container_number')
                                            ->label('Nomor Container'),
                                        TextInput::make('seal_number')
                                            ->label('Nomor Segel'),
                                        TextInput::make('lock_number')
                                            ->label('Nomor Gembok'),
                                    ])
                                    ->columns(3),
                                ] : []),

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

    public function table(Table $table): Table
    {
        $orderProses = $this->getOwnerRecord();

        $isContainerForward = $orderProses?->type_proses === 'container'
            && $orderProses?->operation_proses === 'teruskan';

        return $table
            ->columns([
                Tables\Columns\TextColumn::make('date_detail')
                    ->label('Tanggal')
                    ->date()
                    ->sortable(),

                Tables\Columns\TextColumn::make('trucks.plate_number')
                    ->label('No Polisi')
                    ->sortable(),

                    ...(!$isContainerForward ? [
                    Tables\Columns\TextColumn::make('bag_send')
                        ->label('Qty')
                        ->formatStateUsing(function ($record){
                            $send = $record->bag_send ? number_format($record->bag_send, 0, '.', '.') . ' Bag' : '- Bag';
                            $received = $record->bag_received ? number_format($record->bag_received, 0, '.', '.') . ' Bag' : '- Bag';
                            return collect([$send, $received])->filter()->join('<br>');
                        })->html()->sortable(),

                    Tables\Columns\TextColumn::make('bruto')
                        ->label('Berat')
                        ->formatStateUsing(function ($record){
                            $bruto = $record->bruto ? 'Bruto: ' . number_format($record->bruto, 0, '.', '.') : '-';
                            $tara = $record->tara ? 'Tara: ' . number_format($record->tara, 0, '.', '.') : '-';
                            $netto = $record->netto ? 'Netto: ' . number_format($record->netto, 0, '.', '.') : '-';
                            return collect([$bruto, $tara, $netto])->filter()->join('<br>');
                        })->html(),
                ] : []),

                ...($isContainerForward ? [
                    Tables\Columns\TextColumn::make('container_number')
                        ->label('Container Info')
                        ->formatStateUsing(function ($record) {
                            $container = $record->container_number ?: '-';
                            $seal = $record->seal_number ?: '-';
                            $lock = $record->lock_number ?: '-';
                            return collect([
                                "Container: $container",
                                "Seal: $seal",
                                "Lock: $lock",
                            ])->filter()->join('<br>');
                        })->html(),
                ] : []),

                Tables\Columns\TextColumn::make('total_biaya')
                    ->label('Tagihan')
                    ->formatStateUsing(fn ($state) => 'Rp ' . number_format($state, 0, ',', '.'))
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
            ])
            ->actions([
                ActionGroup::make([
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
                Tables\Actions\CreateAction::make()
                    ->label('New Data')
                    ->icon('heroicon-o-plus-circle')
                    ->fillForm(fn () => [
                        'order_proses_id' => $this->getOwnerRecord()->id,
                    ])
                    ->mutateFormDataUsing(fn (array $data) => [
                        ...$data,
                        'order_proses_id' => $this->getOwnerRecord()->id,
                    ])
                    ->successNotification(
                        Notification::make()
                            ->title('Data berhasil ditambahkan')
                            ->success()
                    ),
            ]);
    }
}
