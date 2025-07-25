<?php

namespace App\Filament\Resources;

use App\Filament\Resources\InvoiceResource\Pages;
use Filament\Tables\Actions\Action;
use App\Models\Invoice;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\OrderProses;
use App\Filament\Forms\Components\CustomTableRepeater;
use App\Filament\Forms\Components\DocumentFooterSection;
use App\Filament\Forms\Components\DocumentHeaderSection;
use App\Filament\Forms\Components\DocumentTotals;
//use BezhanSalleh\FilamentShield\Contracts\HasShieldPermissions;
use Filament\Forms;
use Filament\Notifications\Notification;
use Filament\Forms\Components\{DatePicker, Repeater, Select, TextInput};
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Filament\Tables;
use Filament\Tables\Columns\{TextColumn, BadgeColumn};

class InvoiceResource extends Resource
{
    protected static ?string $model = Invoice::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationGroup = 'Finance';
    protected static ?string $navigationLabel = 'Invoices';
    protected static ?string $modelLabel = 'Invoice';
    protected static ?int $navigationSort = 6;

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
                Forms\Components\Section::make('Invoice Detail')
                    ->schema([
                        Forms\Components\Split::make([
                            Forms\Components\Group::make([
                                Select::make('order_id')
                                ->label('Nomor SPK')
                                ->relationship('order', 'spk_number') 
                                ->preload()
                                ->searchable()
                                ->live()
                                ->afterStateUpdated(function ($state, callable $set) {
                                    $order = Order::find($state);
                                    if ($order) {
                                        $set('customer_name', $order->customers->name);
                                    }
                                })
                                ->required(),

                                TextInput::make('customer_name')
                                ->label('Customer')
                                ->live()
                                ->dehydrated(true)
                                ->disabled(),
                            ]),
                            Forms\Components\Group::make([
                                

                                TextInput::make('invoice_number')
                                ->label('Nomor Invoice')
                                ->required()
                                ->unique(),

                                DatePicker::make('invoice_date')
                                ->label('Tanggal Invoice')
                                ->default(now())
                                ->required(),

                                DatePicker::make('due_date')
                                ->label('Jatuh Tempo'),
                            ])
                        ]),

                        Repeater::make('items')
                            ->label('Item Invoice')
                            ->relationship()
                            ->dehydrated(true)
                            ->reorderable()
                            ->schema([
                                Select::make('order_proses_id')
                                    ->label('DO/PO/SO')
                                    ->relationship('order_proses', 'do_number')
                                    ->searchable()
                                    ->preload()
                                    ->reactive()
                                    ->afterStateUpdated(function ($state, callable $get, callable $set) {
                                        $orderProses = OrderProses::with('order_detail')->find($state);
                                        if (!$orderProses) {
                                            $set('tarif', 0);
                                            $set('total_netto', 0);
                                            $set('amount', 0);
                                            return;
                                        }

                                        $tarif = $orderProses->tarif ?? 0;
                                        $netto = $orderProses->total_netto ?? 0;
                                        $amount = $tarif * $netto;

                                        $set('tarif', $tarif);
                                        $set('total_netto', $netto);
                                        $set('amount', $amount);

                                        // Hitung ulang total amount dari seluruh item
                                        $items = $get('../../items') ?? [];
                                        $subtotal = collect($items)->sum('amount');
                                        $set('../../total_amount', $subtotal);
                                    })
                                    ->required(),

                                TextInput::make('description')
                                    ->label('Deskripsi')
                                    ->required(),

                                TextInput::make('tarif')
                                    ->label('Tarif')
                                    ->prefix('Rp')
                                    ->numeric()
                                    ->disabled()
                                    ->reactive()
                                    ->required(),

                                TextInput::make('total_netto')
                                    ->label('Berat (Netto)')
                                    ->suffix('Kg')
                                    ->numeric()
                                    ->disabled()
                                    ->reactive()
                                    ->required(),

                                TextInput::make('amount')
                                    ->label('Biaya')
                                    ->prefix('Rp')
                                    ->numeric()
                                    ->disabled()
                                    ->dehydrated(true)
                                    ->reactive()
                                    ->required(),
                            ])
                            ->columns(5)
                            ->createItemButtonLabel('Tambah DO/PO/SO'),
                        
                        TextInput::make('total_amount')
                            ->label('Subtotal')
                            ->prefix('Rp')
                            ->disabled()
                            ->dehydrated(true)
                            ->numeric()
                            ->reactive()
                            ->extraAttributes(['class' => 'text-right sm:text-right']),

                        TextInput::make('notes')
                            ->label('Deskription')
                            
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                BadgeColumn::make('status')
                    ->formatStateUsing(fn (?string $state) => [
                        'draft' => 'Draft',
                        'sent' => 'Unpaid',
                        'paid' => 'Paid',
                    ][$state] ?? 'Tidak diketahui')
                    ->color(fn (?string $state) => match ($state) {
                        'draft' => 'info',
                        'sent' => 'danger',
                        'paid' => 'success',
                        default => 'info',
                    }),
                TextColumn::make('invoice_number')->label('Invoice'),
                TextColumn::make('invoice_date')->label('Tanggal'),
                TextColumn::make('customer_name')->label('Customer'),
                TextColumn::make('order.spk_number')->label('SPK'),
                TextColumn::make('total_amount')
                    ->label('Total')
                    ->formatStateUsing(fn ($state) => 'Rp '. number_format($state, 0, ',', '.')),
            ])
            ->filters([])
            ->modifyQueryUsing(function ($query) {
                return $query->latest();
            })
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\Action::make('download_pdf')
                        ->label('Cetak PDF')
                        ->icon('heroicon-o-document-arrow-down')
                        ->color('primary')
                        ->url(fn ($record) => route('invoice.pdf', $record))
                        ->openUrlInNewTab(),
                    
                    Tables\Actions\Action::make('markAsPaid')
                        ->label('Pembayaran')
                        ->color('success')
                        ->icon('heroicon-o-banknotes')
                        ->visible(fn ($record) => is_null($record->paid_at))
                        ->requiresConfirmation()
                        ->action(function ($record) {
                            $record->update(['paid_at' => now(), 'status' => 'paid']);
                            Notification::make()
                                ->title('Invoice ditandai sebagai dibayar.')
                                ->success()
                                ->send();
                        }),

                    Tables\Actions\ViewAction::make()
                        ->color('info'),

                    Tables\Actions\EditAction::make()
                        ->color('warning'),
                ]),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListInvoices::route('/'),
            'create' => Pages\CreateInvoice::route('/create'),
            'edit' => Pages\EditInvoice::route('/{record}/edit'),
            'view' => Pages\ViewInvoice::route('/{record}'),
        ];
    }
}