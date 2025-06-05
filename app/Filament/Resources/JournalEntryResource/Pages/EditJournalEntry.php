<?php

namespace App\Filament\Resources\JournalEntryResource\Pages;

use App\Filament\Resources\JournalEntryResource;
use Filament\Resources\Pages\EditRecord;
use Filament\Notifications\Notification;

class EditJournalEntry extends EditRecord
{
    protected static string $resource = JournalEntryResource::class;

    // protected function mutateFormDataBeforeSave(array $data): array
    // {
    //     $totalDebit = collect($data['lines'])->sum('debit');
    //     $totalCredit = collect($data['lines'])->sum('credit');

    //     if ($totalDebit !== $totalCredit) {
    //         Notification::make()
    //             ->title('Gagal Menyimpan')
    //             ->body('Total Debit dan Kredit harus seimbang.')
    //             ->danger()
    //             ->persistent()
    //             ->send();

    //         $this->halt(); // Stop proses update
    //     }

    //     return $data;
    // }

    protected function beforeSave(): void
    {
        $lines = $this->form->getState()['lines'] ?? [];

        $totalDebit = collect($lines)->sum('debit');
        $totalCredit = collect($lines)->sum('credit');

        if ($totalDebit !== $totalCredit) {
            Notification::make()
                ->title('Gagal Menyimpan')
                ->body("Total debit dan kredit harus seimbang.\n\nDebit: Rp " . number_format($totalDebit) . "\nKredit: Rp " . number_format($totalCredit))
                ->danger()
                ->persistent()
                ->send();

            $this->halt();
        }
    }
}