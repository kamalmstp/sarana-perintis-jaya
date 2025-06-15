<?php

namespace App\Filament\Resources\RentalPaymentResource\Widgets;

use Filament\Widgets\Widget;


class RentalPaymentViewCard extends Widget
{

    protected static string $view = 'filament.resources.rental-payment-resource.widgets.rental-payment-view-card';

    public $record;

    public function mount() : void 
    {
        $this->record = $this->record->load('rental', 'rentalCosts.orderDetail.trucks');
    }

    protected static bool $isLazy = false;
}
