<?php

namespace App\Filament\Resources\InvoiceResource\Pages;

use App\Filament\Resources\InvoiceResource\Widgets\InvoiceItemList;
use App\Filament\Resources\InvoiceResource;
use Filament\Actions;
use App\Models\Account;
use App\Models\JournalEntry;
use Filament\Resources\Pages\ViewRecord;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ViewRecord\Concerns\CanCustomizeViewRecordPage;
use Filament\Support\Enums\Alignment;
use Filament\Widgets\StatsOverviewWidget\Card;
use App\Filament\Resources\InvoiceResource\Widgets\InvoiceOverview;
use Illuminate\Support\Facades\Storage;
use Illuminate\Contracts\View\View;

class ViewInvoice extends ViewRecord
{
    protected static string $resource = InvoiceResource::class;
    protected static bool $canCreateAnother = false;
    protected static string $view = 'invoices.view-pdf';
    //customize redirect after create
    public function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getHeaderWidgets(): array
    {
         return [
        //     InvoiceOverview::make(['record' => $this->record]),
         ];
    }

    protected function getFooterWidgets(): array
    {
        return [
//            InvoiceItemList::make(['record' => $this->record]),
        ];
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
            Actions\DeleteAction::make(),
            Actions\Action::make('generatePdf')
            ->label('Generate PDF')
            ->icon('heroicon-o-document')
            ->requiresConfirmation()
            ->action(function () {
                $invoice = $this->record;

                $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pdf.invoice', compact('invoice'));
                $pdfContent = $pdf->output();

                $path = "invoices/invoice-{$invoice->id}.pdf";
                Storage::disk('public')->put($path, $pdfContent);

                $invoice->update([
                    'pdf_path' => $path,
                ]);

                \Filament\Notifications\Notification::make()
                    ->title('PDF berhasil digenerate!')
                    ->success()
                    ->send();
            }),
            Actions\Action::make('markAsPaid')
                ->label('Pembayaran')
                ->color('success')
                ->icon('heroicon-o-banknotes')
                ->visible(fn () => $this->record->paid_at === null)
                ->requiresConfirmation()
                ->action(function () {
                    $this->record->update([
                        'paid_at' => now(),
                        'status' => 'paid',
                    ]);

                    $this->createJournalOnPayment();

                    Notification::make()
                        ->title('Invoice ditandai sebagai dibayar.')
                        ->success()
                        ->send();
                }),
        ];
    }

    public function getContent(): View
    {
        $invoice = $this->record;
        $pdfUrl = $invoice->pdf_path
            ? Storage::url($invoice->pdf_path)
            : route('invoices.pdf.preview', $invoice);

        return view('invoices.view-pdf', compact('pdfUrl'));
    }

    protected function createJournalOnPayment(): void
    {
        $invoice = $this->record;

        if (JournalEntry::where('reference_type', get_class($invoice))
            ->where('reference_id', $invoice->id)
            ->where('description', 'like', '%Pembayaran%')->exists()) {
            return;
        }

        $journal = JournalEntry::create([
            'date' => $invoice->paid_at,
            'description' => 'Pembayaran Invoice #' . $invoice->invoice_number,
            'reference_type' => get_class($invoice),
            'reference_id' => $invoice->id,
        ]);

        $kas = Account::where('code', '1100')->first(); // Kas
        $piutang = Account::where('code', '1200')->first(); // Piutang Usaha

        $journal->lines()->createMany([
            [
                'account_id' => $kas->id,
                'debit' => $invoice->total_amount,
                'credit' => 0,
            ],
            [
                'account_id' => $piutang->id,
                'debit' => 0,
                'credit' => $invoice->total_amount,
            ],
        ]);
    }
}
