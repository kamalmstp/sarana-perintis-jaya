<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Filament\Forms;
use App\Models\Account;
use App\Models\JournalEntryLine;
use Illuminate\Support\Facades\DB;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use BezhanSalleh\FilamentShield\Traits\HasPageShield;

class GeneralLedger extends Page implements HasForms
{
    use InteractsWithForms, HasPageShield;

    protected static ?string $navigationIcon = 'heroicon-o-book-open';
    protected static string $view = 'filament.pages.general-ledger';
    protected static ?string $title = 'Buku Besar';
    protected static ?string $navigationGroup = 'Report';
    protected static ?int $navigationSort = 11;

    public ?int $account_id = null;
    public ?string $start_date = null;
    public ?string $end_date = null;

    public array $transactions = [];

    public function mount(): void
    {
        $this->start_date = now()->startOfMonth()->toDateString();
        $this->end_date = now()->endOfMonth()->toDateString();
        $this->account_id = null;
    }

    public function getFormSchema(): array
    {
        return [
            Forms\Components\Select::make('account_id')
                ->label('Pilih Akun')
                ->options(Account::pluck('name', 'id'))
                ->searchable()
                ->required(),

            Forms\Components\DatePicker::make('start_date')
                ->label('Tanggal Mulai')
                ->required(),

            Forms\Components\DatePicker::make('end_date')
                ->label('Tanggal Akhir')
                ->required(),
        ];
    }

    public function loadTransactions(): void
    {
        if (!$this->account_id) {
            $this->transactions = [];
            return;
        }

        $saldoAwal = JournalEntryLine::where('account_id', $this->account_id)
            ->whereHas('journalEntry', function ($q) {
                $q->where('posted', true)->where('date', '<', $this->start_date);
            })
            ->selectRaw('SUM(debit) as total_debit, SUM(credit) as total_credit')
            ->first();

        $openingBalance = ($saldoAwal->total_debit ?? 0) - ($saldoAwal->total_credit ?? 0);

        $entries = JournalEntryLine::with('journalEntry')
            ->where('account_id', $this->account_id)
            ->whereHas('journalEntry', function ($q) {
                $q->where('posted', true)
                    ->whereBetween('date', [$this->start_date, $this->end_date]);
            })
            ->join('journal_entries', 'journal_entries.id', '=', 'journal_entry_lines.journal_entry_id')
            ->orderBy('journal_entries.date')
            ->select('journal_entry_lines.*')
            ->get();

        $balance = $openingBalance;
        $this->transactions = [];

        $this->transactions[] = [
            'date' => null,
            'description' => 'Saldo Awal',
            'debit' => null,
            'credit' => null,
            'balance' => $balance,
        ];

        foreach ($entries as $entry) {
            $balance += ($entry->debit - $entry->credit);
            $this->transactions[] = [
                'date' => $entry->journalEntry->date,
                'description' => $entry->journalEntry->description,
                'debit' => $entry->debit,
                'credit' => $entry->credit,
                'balance' => $balance,
            ];
        }
    }
}