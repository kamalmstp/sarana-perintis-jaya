<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderProsesResource\Pages;
use App\Filament\Resources\OrderProsesResource\RelationManagers;
use App\Filament\Resources\OrderProsesResource\RelationManagers\OrderDetailRelationManager;
use App\Models\OrderProses;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use Filament\Notifications\Notification;
use Filament\Forms;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Get;
use Filament\Forms\Form;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Filament\Resources\Pages\Page;
use Filament\Resources\Resource;
use Filament\Pages\SubNavigationPosition;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Actions\BulkAction;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class OrderProsesResource extends Resource
{
    protected static ?string $model = OrderProses::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-check';
    protected static ?string $navigationGroup = 'Order Management';
    protected static ?string $navigationLabel = 'Order (DO/PO/SO)';
    protected static ?int $navigationSort = 3;

    protected static SubNavigationPosition $subNavigationPosition = SubNavigationPosition::Top;

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

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Group::make()
                    ->schema([
                        Section::make('Order DO/PO/SO')
                            ->schema([
                                Forms\Components\Select::make('order_id')
                                ->label('No SPK')
                                ->relationship(name:'orders', titleAttribute:'spk_number')
                                ->searchable()
                                ->preload()
                                ->required(),

                                Fieldset::make('Nomor Order')
                                ->schema([
                                    Forms\Components\TextInput::make('do_number')
                                    ->label('DO')
                                    ->maxLength(255)
                                    ->default(null),
                                    Forms\Components\TextInput::make('po_number')
                                    ->label('PO')
                                    ->maxLength(255)
                                    ->default(null),
                                    Forms\Components\TextInput::make('so_number')
                                    ->label('SO')
                                    ->maxLength(255)
                                    ->default(null),
                                    Forms\Components\TextInput::make('tally_proses')
                                    ->label('Nama Tally')
                                    ->maxLength(255)
                                    ->default(null),
                                ]),

                                Fieldset::make('Informasi Barang')
                                ->schema([
                                    Forms\Components\TextInput::make('item_proses')
                                        ->label('Item')
                                        ->maxLength(255)
                                        ->default(null),
                                    Forms\Components\TextInput::make('total_kg_proses')
                                        ->label('Quantity')
                                        ->suffix('Kg')
                                        ->numeric()
                                        ->default(null),
                                    Forms\Components\TextInput::make('total_bag_proses')
                                        ->label('Quantity')
                                        ->suffix('Bag')
                                        ->numeric()
                                        ->default(null),
                                ]),

                                Forms\Components\Select::make('delivery_location_id')
                                ->label('Lokasi Tujuan')
                                ->relationship(name:'locations', titleAttribute:'address')
                                ->searchable()
                                ->preload()
                                ->createOptionForm(fn (Form $form) => LocationResource::form($form))
                                ->required(),
                            ]),
                    ])
                    ->columnSpan(['lg' => 2]),
                
                Group::make()
                    ->schema([
                        Section::make('Pengiriman')
                            ->schema([
                                Forms\Components\TextInput::make('tarif')
                                ->label('Tarif')
                                ->numeric()
                                ->prefix('Rp')
                                ->required(),

                                Forms\Components\Select::make('type_proses')
                                ->label('Tipe')
                                ->options([
                                    'gudang' => 'Gudang',
                                    'kapal' => 'Kapal',
                                    'container' => 'Container'
                                ])
                                ->searchable()
                                ->preload()
                                ->reactive()
                                ->required(),

                                Forms\Components\TextInput::make('warehouse_proses')
                                ->label('Informasi Gudang')
                                ->visible(fn(Get $get) => $get('type_proses') === 'gudang')
                                ->default(null),

                                Forms\Components\TextInput::make('vessel_name_proses')
                                ->label('Nama Kapal')
                                ->visible(fn(Get $get) => $get('type_proses') === 'kapal')
                                ->default(null),

                                Forms\Components\Select::make('operation_proses')
                                ->label('Container Proses')
                                ->visible(fn(Get $get) => $get('type_proses') === 'container')
                                ->reactive()
                                ->options([
                                    'bongkar' => 'Bongkar',
                                    'teruskan' => 'Teruskan'
                                ]),

                                Forms\Components\TextInput::make('total_container_proses')
                                ->label('Jumlah Container')
                                ->numeric()
                                ->visible(fn(Get $get) => $get('type_proses') === 'container' && $get('operation_proses') === 'teruskan')
                                ->default(null),

                                Forms\Components\RichEditor::make('note_proses')
                                ->label('Keterangan')
                                ->columnSpanFull(),
                            ]),
                    ]),
    
            ])
            ->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('do_number')
                    ->label('Nomor')
                    ->formatStateUsing(function ($record){
                        return collect([
                            $record->do_number ? "DO: {$record->do_number}" : "DO: -",
                            $record->po_number ? "PO: {$record->po_number}" : "PO: -",
                            $record->so_number ? "SO: {$record->so_number}" : "SO: -",
                        ])->filter()->join('<br>');
                    })->html()
                    ->searchable(),
                Tables\Columns\TextColumn::make('item_proses')
                    ->label('Item')
                    ->searchable(),
                Tables\Columns\TextColumn::make('total_kg_proses')
                    ->label('Quantity')
                    ->formatStateUsing(function ($record){
                        $kg = $record->total_kg_proses ? number_format($record->total_kg_proses, 0, '.', '.') . ' Kg' : '- Kg' ;
                        $bag = $record->total_bag_proses ? number_format($record->total_bag_proses, 0, '.', '.') . ' Bag' : '- Bag' ;

                        return collect([$kg, $bag])->filter()->join('<br>');
                    })->html()
                    ->sortable(),
                // Tables\Columns\TextColumn::make('locations.address')
                //     ->label('Lokasi Tujuan')
                //     ->sortable(),
                Tables\Columns\TextColumn::make('tarif')
                    ->label('Tarif')
                    ->formatStateUsing(fn ($state) => 'Rp '. number_format($state, 0, ',', '.'))
                    ->sortable()
                    ->alignEnd(),
                Tables\Columns\BadgeColumn::make('status')
                    ->label('Status')
                    ->getStateUsing(fn ($record) => $record->status) // karena ini accessor, bukan field database
                    ->formatStateUsing(fn (?string $state) => [
                        'belum_dimulai' => 'Belum Dimulai',
                        'dalam_proses' => 'Dalam Proses',
                        'selesai' => 'Selesai',
                    ][$state] ?? 'Tidak diketahui')
                    ->color(fn (?string $state) => match ($state) {
                        'belum_dimulai' => 'info',
                        'dalam_proses' => 'danger',
                        'selesai' => 'success',
                        default => 'info',
                    }),
                Tables\Columns\TextColumn::make('invoice_status')
                    ->label('Status')
                    ->toggleable(isToggledHiddenByDefault: true),
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
                        BulkAction::make('createInvoice')
                        ->label('Buat Invoice')
                        ->action(function (Collection $records, array $data) {
                            // Ambil customer dari salah satu record (asumsi sama semua)
                            $customer = $records->first()->order->spk->customer ?? null;

                            $invoice = Invoice::create([
                                'customer_id' => $customer->id,
                                'invoice_number' => 'INV-' . now()->format('Ymd-His'),
                                'invoice_date' => now(),
                                'status' => 'draft',
                                'created_by' => auth()->id(),
                            ]);

                            foreach ($records as $record) {
                                InvoiceItem::create([
                                    'invoice_id' => $invoice->id,
                                    'order_detail_id' => $record->id,
                                    'description' => "Pengiriman {$record->order->do_number} ke {$record->destination}",
                                    'amount' => $record->tarif, // pastikan kamu punya field ini
                                ]);
                            }

                            Notification::make()
                                ->title('Invoice berhasil dibuat')
                                ->success()
                                ->send();
                        })
                        ->requiresConfirmation()
                        ->deselectRecordsAfterCompletion()
                        ->visible(fn () => auth()->user()->can('create', Invoice::class))
                        ->icon('heroicon-o-document-text'),
                    ]),
            ]);
    }

    public static function getRecordSubNavigation(Page $page): array
    {
        return $page->generateNavigationItems([
            Pages\ViewOrderProses::class,
            Pages\EditOrderProses::class,
            Pages\ManageOrderDetail::class,
        ]);
    }

    public static function getRelations(): array
    {
        return [
            OrderDetailRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrderProses::route('/'),
            'create' => Pages\CreateOrderProses::route('/create'),
            'view' => Pages\ViewOrderProses::route('/{record}'),
            'edit' => Pages\EditOrderProses::route('/{record}/edit'),
            'order-detail' => Pages\ManageOrderDetail::route('/{record}/order-detail'),
        ];
    }
}
