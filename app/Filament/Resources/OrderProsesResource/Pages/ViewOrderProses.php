<?php

namespace App\Filament\Resources\OrderProsesResource\Pages;

use App\Filament\Resources\OrderProsesResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use Filament\Infolists\Components\Infolist;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextColumn;
use Filament\Infolists\Components\RichContent;

class ViewOrderProses extends ViewRecord
{
    protected static string $resource = OrderProsesResource::class;
    protected static bool $canCreateAnother = false;

    //customize redirect after create
    // public function getRedirectUrl(): string
    // {
    //     return $this->getResource()::getUrl('index');
    // }

    protected function getViewContent(): array
    {
        return [
            Infolist::make()
                ->schema([
                    Section::make('Order DO/PO/SO')
                        ->schema([
                            TextColumn::make('order.spk_number')
                                ->label('No SPK'),
                            TextColumn::make('do_number')->label('DO'),
                            TextColumn::make('po_number')->label('PO'),
                            TextColumn::make('so_number')->label('SO'),
                            TextColumn::make('tally_proses')->label('Nama Tally'),
                        ]),

                    Section::make('Informasi Barang')
                        ->schema([
                            TextColumn::make('item_proses')->label('Item'),
                            TextColumn::make('total_kg_proses')
                                ->label('Quantity (Kg)')
                                ->formatStateUsing(fn($state) => $state ? number_format($state, 0, ',', '.') . ' Kg' : '-'),
                            TextColumn::make('total_bag_proses')
                                ->label('Quantity (Bag)')
                                ->formatStateUsing(fn($state) => $state ? number_format($state, 0, ',', '.') . ' Bag' : '-'),
                        ]),

                    Section::make('Lokasi Tujuan')
                        ->schema([
                            TextColumn::make('deliveryLocation.address')
                                ->label('Alamat'),
                        ]),

                    Section::make('Pengiriman')
                        ->schema([
                            TextColumn::make('tarif')
                                ->label('Tarif')
                                ->formatStateUsing(fn($state) => $state ? 'Rp ' . number_format($state, 0, ',', '.') : '-'),
                            TextColumn::make('type_proses')
                                ->label('Tipe'),
                            TextColumn::make('warehouse_proses')
                                ->label('Informasi Gudang')
                                ->visible(fn($record) => $record->type_proses === 'gudang'),
                            TextColumn::make('vessel_name_proses')
                                ->label('Nama Kapal')
                                ->visible(fn($record) => $record->type_proses === 'kapal'),
                            TextColumn::make('operation_proses')
                                ->label('Container Proses')
                                ->visible(fn($record) => $record->type_proses === 'container'),
                            TextColumn::make('total_container_proses')
                                ->label('Jumlah Container')
                                ->visible(fn($record) => $record->type_proses === 'container' && $record->operation_proses === 'teruskan'),
                            RichContent::make('note_proses')
                                ->label('Keterangan'),
                        ]),
                ]),
        ];
    }

    public static function getNavigationLabel(): string
    {
        return 'Informasi';
    }
}
