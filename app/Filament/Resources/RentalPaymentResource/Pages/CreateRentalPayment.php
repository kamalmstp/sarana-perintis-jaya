<?php

namespace App\Filament\Resources\RentalPaymentResource\Pages;

use App\Models\RentalCosts;
use App\Models\RentalPayment;
use App\Filament\Resources\RentalPaymentResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateRentalPayment extends CreateRecord
{
    protected static string $resource = RentalPaymentResource::class;
    protected static bool $canCreateAnother = false;

    //customize redirect after create
    public function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Hitung total otomatis
        $total = RentalCosts::whereIn('id', $data['rental_costs'])->get()->sum(fn ($c) => $c->tarif_rental * $c->qty);

        $data['total_amount'] = $total;
        $data['receipt_number'] = 'RP-' . now()->format('Ymd') . '-' . str_pad(RentalPayment::count() + 1, 4, '0', STR_PAD_LEFT);

        return $data;
    }

    protected function afterCreate(): void
    {
        $payment = $this->record;

        $rentalCostIds = $this->data['rental_costs'] ?? [];

        // Simpan pivot
        $payment->rentalCosts()->attach($rentalCostIds);

        // Optional: Ubah status rental_cost jadi "paid"
        RentalCosts::whereIn('id', $rentalCostIds)->update([
            'status' => 'paid',
        ]);
    }
}
