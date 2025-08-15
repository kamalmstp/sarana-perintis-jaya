<?php

namespace App\Filament\Resources\OrderProsesResource\RelationManagers;

use Carbon\Carbon;
use Filament\Resources\RelationManagers\RelationManager;
use App\Models\{OrderDetail, OrderProses};
use App\Filament\Resources\{ShipResource, ShippingLineResource};
use Filament\Forms;
use Filament\Forms\{Get, Set, Form};
use Filament\Forms\Components\{Group, Section, Fieldset, Hidden, Radio, TextInput, Select};
use Illuminate\Database\Eloquent\Model;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Actions\{Action, ActionGroup};
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Notifications\Notification;

class PtpOrderDetailsRelationManager extends RelationManager
{
    protected static string $relationship = 'order_detail';
    protected static ?string $title = 'Port To Port';

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('segment', 'PTP');
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
                        Section::make('Order (Shipping)')
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
                                        ->default('PTP')
                                        ->dehydrated(),
                                ]),

                                Fieldset::make('Shipping')
                                    ->schema([
                                        Forms\Components\DatePicker::make('eta')
                                            ->label('Estimate Time of Arrival (ETA)'),
                                    
                                        Forms\Components\DatePicker::make('etd')
                                            ->label('Estimate Time of Departure (ETD)'),

                                        Forms\Components\Select::make('ship_id')
                                            ->label('Ship')
                                            ->relationship('ships', 'name')
                                            ->preload()
                                            ->searchable()
                                            ->createOptionForm(fn (Form $form) => ShipResource::form($form))
                                            ->required(),

                                        Forms\Components\Select::make('shipping_line_id')
                                            ->label('Shipping Line')
                                            ->relationship('shipping_lines', 'name')
                                            ->preload()
                                            ->searchable()
                                            ->createOptionForm(fn (Form $form) => ShippingLineResource::form($form))
                                            ->default(null),
                                    ]),

                                    Fieldset::make('Pengiriman')
                                        ->schema([
                                            Forms\Components\DatePicker::make('date_muat')
                                                ->label('Tanggal Muat'),
                                            
                                            Forms\Components\DatePicker::make('date_bongkar')
                                                ->label('Tanggal Bongkar'),

                                            Forms\Components\TextInput::make('kg_send')
                                                ->label('Kirim')
                                                ->suffix('Kg')
                                                ->numeric()
                                                ->default(null),

                                            Forms\Components\TextInput::make('kg_received')
                                                ->label('Terima')
                                                ->suffix('Kg')
                                                ->numeric()
                                                ->default(null),
                                        ]),

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
            ->recordTitleAttribute('Port To Port')
            ->modifyQueryUsing(fn (Builder $query) => 
                $query->where('segment_type', 'PTP')
            )
            ->columns([
                Tables\Columns\TextColumn::make('eta')
                    ->label('Tanggal')
                    ->formatStateUsing(function ($record){
                        $eta = $record->eta ? 'ETA : '.Carbon::parse($record->eta)->format('d M Y') : '-';
                        $etd = $record->etd ? 'ETD : '.Carbon::parse($record->etd)->format('d M Y') : '-';
                        return collect([$eta,$etd])->filter()->join('<br>');
                    })->html(),

                Tables\Columns\TextColumn::make('shipping_lines.name')
                    ->label('Pelayaran'),

                Tables\Columns\TextColumn::make('ships.name')
                    ->label('Kapal'),

                Tables\Columns\TextColumn::make('kirim')
                    ->label('Muat')
                    ->html(),

                Tables\Columns\TextColumn::make('terima')
                    ->label('Bongkar')
                    ->html(),

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
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
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
