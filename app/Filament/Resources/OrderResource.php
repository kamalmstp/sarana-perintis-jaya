<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderResource\Pages;
use App\Filament\Resources\OrderResource\RelationManagers;
use App\Filament\Resources\OrderResource\RelationManagers\OrderProsesRelationManager;
use App\Models\Order;
use Filament\Actions\Action;
use Filament\Support\Enums\ActionSize;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Filament\Pages\SubNavigationPosition;
use Filament\Resources\Pages\Page;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use pxlrbt\FilamentExcel\Actions\Tables\ExportAction;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document';
    protected static ?string $navigationGroup = 'Order Management';
    protected static ?string $navigationLabel = 'Order (SPK)';
    protected static ?int $navigationSort = 2;

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
                Forms\Components\Select::make('customer_id')
                    ->label('Customer')
                    ->relationship(name: 'customers', titleAttribute:'name')
                    ->searchable()
                    ->preload()
                    ->createOptionForm(fn (Form $form) => CustomerResource::form($form))
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
                    ->preload()
                    ->createOptionForm(fn (Form $form) => LocationResource::form($form))
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
                Tables\Columns\TextColumn::make('customers.code')
                    ->label('Customer')
                    ->sortable(),
                Tables\Columns\TextColumn::make('spk_date')
                    ->label('Tanggal')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('spk_number')
                    ->label('No SPK')
                    ->searchable(),
                
                Tables\Columns\TextColumn::make('delivery_term')
                    ->label('Pengiriman')
                    ->formatStateUsing(function ($state){
                        return match ($state){
                            'dtd' => 'Door to Door',
                            'dtp' => 'Door to Port',
                            'ptd' => 'Port to Door',
                            'ptp' => 'Port to Port',
                        };
                    })
                    ->sortable(),
                Tables\Columns\TextColumn::make('total_kg')
                    ->formatStateUsing(function ($record){
                        $kg = $record->total_kg ? number_format($record->total_kg, 0, '.', '.') . ' Kg' : '- Kg' ;
                        $bag = $record->total_bag ? number_format($record->total_bag, 0, '.', '.') . ' Bag' : '- Bag' ;

                        return collect([$kg, $bag])->filter()->join('<br>');
                    })->html()
                    ->label('Quantity'),
                Tables\Columns\BadgeColumn::make('status')
                ->label('Status')
                ->getStateUsing(fn ($record) => $record->status)
                ->formatStateUsing(fn (?string $state) => [
                    'draft' => 'Draft',
                    'proses' => 'Proses',
                    'selesai_sebagian' => 'Selesai Sebagian',
                    'selesai' => 'Selesai',
                ][$state] ?? 'Tidak diketahui')
                ->color(fn (?string $state) => match ($state) {
                    'draft' => 'info',
                    'proses' => 'warning',
                    'selesai_sebagian' => 'danger',
                    'selesai' => 'success',
                    default => 'info',
                }),
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
            ->modifyQueryUsing(function ($query) {
                return $query->latest();
            })
            ->paginated()
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
  
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
    
    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Infolists\Components\Group::make()
                    ->schema([
                        Infolists\Components\Section::make('Informasi Order')
                            ->schema([
                                Infolists\Components\Grid::make()
                                    ->schema([
                                        Infolists\Components\TextEntry::make('customers.name')
                                            ->label('Customer')
                                            ->icon('heroicon-o-building-office')
                                            ->listWithLineBreaks()
                                            ->placeholder('—'),

                                        Infolists\Components\TextEntry::make('spk_date')
                                            ->label('Tanggal')
                                            ->icon('heroicon-o-calendar')
                                            ->date()
                                            ->placeholder('—'),

                                        Infolists\Components\TextEntry::make('spk_number')
                                            ->label('Nomor SPK')
                                            ->icon('heroicon-o-clipboard-document')
                                            ->placeholder('—'),

                                        Infolists\Components\TextEntry::make('delivery_term')
                                            ->label('Pengiriman')
                                            ->icon('heroicon-o-arrow-path')
                                            ->formatStateUsing(function ($state){
                                                    return match ($state){
                                                        'dtd' => 'Door to Door',
                                                        'dtp' => 'Door to Port',
                                                        'ptd' => 'Port to Door',
                                                        'ptp' => 'Port to Port',
                                                    };
                                                })
                                            ->placeholder('—'),
                                    ]),
                                
                                
                                Infolists\Components\TextEntry::make('locations.address')
                                    ->label('Lokasi Muat')
                                    ->icon('heroicon-o-map')
                                    ->placeholder('—'),
                                
                                Infolists\Components\TextEntry::make('note')
                                    ->label('Catatan')
                                    ->icon('heroicon-o-map')
                                    ->placeholder('—'),
                            ]),
                    ])
                    ->columnSpan(['lg' => 2]),

                Infolists\Components\Group::make()
                    ->schema(
                        [
                            Infolists\Components\Section::make('Informasi Status')
                                ->schema([
                                    Infolists\Components\TextEntry::make('created_at')
                                        ->label('Created at')
                                        ->dateTime()
                                        ->icon('heroicon-m-calendar'),
                                    Infolists\Components\TextEntry::make('updated_at')
                                        ->label('Updated at')
                                        ->dateTime()
                                        ->icon('heroicon-m-calendar-days'),
                                ]),
                        ]
                    )
                    ->columnSpan(['lg' => 1]),
            ])
            ->columns(3);
    }

    public static function getRecordSubNavigation(Page $page): array
    {
        return $page->generateNavigationItems([
            Pages\ViewOrder::class,
            Pages\EditOrder::class,
            Pages\ManageOrderProses::class,
        ]);
    }

    public static function getRelations(): array
    {
        return [
            OrderProsesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
            'view' => Pages\ViewOrder::route('/{record}'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
            'order-proses' => Pages\ManageOrderProses::route('/{record}/order-proses'),
        ];
    }

    public static function getActions(): array
    {
        return [
            Action::make('buat_invoice')
                ->label('Buat Invoice')
                ->icon('heroicon-m-document-text')
                ->color('primary')
                ->size(ActionSize::Medium)
                ->url(fn (Order $record) => InvoiceResource::getUrl('create', ['order_id' => $record->id]))
                ->visible(fn (Order $record) => $record->order_proses()->exists()), // opsional: hanya jika ada proses
        ];
    }
}
