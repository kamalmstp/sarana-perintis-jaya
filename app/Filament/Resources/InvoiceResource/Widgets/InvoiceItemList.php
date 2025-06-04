<?php

namespace App\Filament\Resources\InvoiceResource\Widgets;

use App\Models\InvoiceItem;
use Filament\Widgets\TableWidget as BaseWidget;
use Filament\Tables;
use Filament\Tables\Table;

class InvoiceItemList extends BaseWidget
{
    public $record;
    protected static ?string $heading = 'Rincian Item Invoice';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                InvoiceItem::query()->where('invoice_id', $this->record->id)
            )
            ->columns([
                Tables\Columns\TextColumn::make('description')->label('Deskripsi'),
                Tables\Columns\TextColumn::make('quantity')->label('Qty'),
                Tables\Columns\TextColumn::make('unit_price')->money('IDR')->label('Harga Satuan'),
                Tables\Columns\TextColumn::make('total')->money('IDR')->label('Subtotal'),
            ]);
    }
}