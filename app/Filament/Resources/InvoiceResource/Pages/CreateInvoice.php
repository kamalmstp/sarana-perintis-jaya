<?php

namespace App\Filament\Resources\InvoiceResource\Pages;

use App\Filament\Resources\InvoiceResource;
use App\Models\Order;
use App\Models\OrderDetail;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Filament\Forms\Components\Select;
use Filament\Actions\Action; // ✅ Pakai ini, bukan Forms\Components\Actions\Action

class CreateInvoice extends CreateRecord
{
    protected static string $resource = InvoiceResource::class;

    public function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}