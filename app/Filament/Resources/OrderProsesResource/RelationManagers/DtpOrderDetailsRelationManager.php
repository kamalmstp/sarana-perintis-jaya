<?php

namespace App\Filament\Resources\OrderProsesResource\RelationManagers;

use Filament\Resources\RelationManagers\RelationManager;
use Illuminate\Database\Eloquent\Model;
use App\Models\{OrderDetail, Truck, OrderProses};
use App\Filament\Resources\{TruckResource, DriverResource};
use Filament\Forms;
use Filament\Forms\{Get, Set, Form};
use Filament\Forms\Components\{Group, Section, Fieldset, Hidden, Radio, TextInput, Select};
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Actions\{Action, ActionGroup};
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Notifications\Notification;

class DtpOrderDetailsRelationManager extends RelationManager
{
    protected static string $relationship = 'order_detail';
    protected static ?string $title = 'Door To Port';

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('segment', 'DTP');
    }

    public static function canViewForRecord(Model $ownerRecord, string $pageClass): bool
    {
        return $ownerRecord->orders?->is_antar_pulau === 1;
    }

    public function form(Form $form): Form
    {
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
                                        ->default(fn (RelationManager $livewire) => $livewire->ownerRecord->id),

                                    Forms\Components\Hidden::make('segment_type')
                                        ->default('DTP')
                                        ->dehydrated(),
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
                                                ->default(0),

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
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('Door To Port')
            ->modifyQueryUsing(fn (Builder $query) => 
                $query->where('segment_type', 'DTP')
            )
            ->columns([
                Tables\Columns\TextColumn::make('date_detail')
                    ->label('Tanggal')
                    ->date()
                    ->sortable(),

                Tables\Columns\TextColumn::make('trucks.plate_number')
                    ->label('No Polisi')
                    ->formatStateUsing(function ($record){
                        $truck = $record->truck_id ? $record->trucks->plate_number : '-' ;
                        $driver = $record->driver_id ? '(' . $record->drivers->name . ')' : '-' ;
                        return collect([$truck, $driver])->filter()->join('<br>');
                    })->html()
                    ->sortable(),

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
            ->filters([
                
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->label('Tambah Data'),
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
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
