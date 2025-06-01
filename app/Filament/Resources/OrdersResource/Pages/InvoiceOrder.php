<?php

namespace App\Filament\Resources\OrdersResource\Pages;

use App\Filament\Resources\OrdersResource;
use Filament\Resources\Pages\Page;

class InvoiceOrder extends Page
{
    protected static string $resource = OrdersResource::class;

    protected static string $view = 'filament.resources.orders-resource.pages.invoice-order';
}
