<?php

namespace App\Filament\Resources\OrderResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use App\Filament\Resources\OrderProsesResource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Actions\{Action, ActionGroup, BulkAction};
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Infolists\Infolist;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Auth;
use Guava\FilamentNestedResources\Concerns\NestedRelationManager;

class OrderProsesRelationManager extends RelationManager
{
    //use NestedRelationManager;
    
    protected static string $relationship = 'order_proses';
    protected static ?string $title = 'Order DO/PO/SO';
    protected static ?string $label = 'Order DO/PO/SO';
    protected static ?string $pluralLabel = 'Order DO/PO/SO';

    public function form(Form $form): Form
    {
        return OrderProsesResource::form($form);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('do_number')
                    ->label('Nomor')
                    ->formatStateUsing(function ($record){
                        return collect([
                            $record->do_number ? "DO: {$record->do_number}" : "",
                            $record->po_number ? "PO: {$record->po_number}" : "",
                            $record->so_number ? "SO: {$record->so_number}" : "",
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
                        $bag = $record->total_bag_proses ? number_format($record->total_bag_proses, 0, '.', '.') . ' Bag' : '' ;

                        return collect([$kg, $bag])->filter()->join('<br>');
                    })->html()
                    ->sortable(),
                Tables\Columns\TextColumn::make('locationsDtp.name')
                    ->label('Lokasi Tujuan')
                    ->sortable()
                    ->formatStateUsing(function($record){
                        $dtp = $record->locationsDtp->name ?  "DTP: {$record->locationsDtp->name}" : '-';
                        $ptp = $record->locationsPtp->name ?  "PTP: {$record->locationsPtp->name}" : '-';
                        $ptd = $record->locationsPtd->name ?  "PTD: {$record->locationsPtd->name}" : '-';

                        return collect([$dtp, $ptp, $ptd])->filter()->join('<br>');
                    })->html()
                    ->visible(fn ($record, $livewire) => $livewire->ownerRecord->is_antar_pulau === 1)
                    ->searchable(),
                Tables\Columns\TextColumn::make('locations.name')
                    ->label('Lokasi Tujuan')
                    ->sortable()
                    ->visible(fn ($record, $livewire) => $livewire->ownerRecord->is_antar_pulau === 0)
                    ->searchable(),
                Tables\Columns\TextColumn::make('tarif')
                    ->label('Tarif')
                    ->formatStateUsing(fn ($state) => 'Rp '. number_format($state, 0, ',', '.'))
                    ->sortable()
                    ->alignEnd(),
                Tables\Columns\BadgeColumn::make('status')
                    ->label('Status')
                    ->getStateUsing(fn ($record) => $record->status)
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
            ->modifyQueryUsing(function ($query) {
                return $query->latest();
            })
            ->paginated()
            ->actions([
                ActionGroup::make([
                    Tables\Actions\ViewAction::make(),

                    Action::make('detail')
                        ->label('Detail')
                        ->icon('heroicon-o-eye')
                        ->color('primary')
                        ->url(fn ($record) => route('filament.admin.resources.order-proses.view', $record))
                        ->openUrlInNewTab(),

                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                ])

            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->label('New Order')
                    ->icon('heroicon-o-plus-circle')
                    ->fillForm(function (array $arguments): array {
                        return [
                            'order_id'   => $this->getOwnerRecord()->id,
                        ];
                    })
                    ->modalWidth('6xl')
                    ->successNotification(
                        Notification::make()
                            ->success(),
                    ),
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
}
