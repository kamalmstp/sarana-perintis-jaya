<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Illuminate\Support\Facades\DB;
use App\Models\Account;
use BezhanSalleh\FilamentShield\Traits\HasPageShield;

class ProfitLossReport extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-chart-bar';

    protected static string $view = 'filament.pages.profit-loss-report';

    protected static ?string $title = 'Laporan Laba Rugi';
    protected static ?string $navigationGroup = 'Report';
    protected static ?int $navigationSort = 9;

    public ?string $startDate = null;
    public ?string $endDate = null;

    public array $revenues = [];
    public array $expenses = [];
    public float $totalRevenue = 0;
    public float $totalExpense = 0;
    public float $netProfit = 0;

    public static function getPermissionPrefixes(): array
    {
        return [
            'view',
            'view_any',
            'create',
            'update',
            'restore',
            'restore_any',
            'replicate',
            'reorder',
            'delete',
            'delete_any',
            'force_delete',
            'force_delete_any',
        ];
    }

    public function mount(): void
    {
        $this->startDate = now()->startOfMonth()->toDateString();
        $this->endDate = now()->endOfMonth()->toDateString();

        $this->generateReport();
    }

    public function updated($property)
    {
        if (in_array($property, ['startDate', 'endDate'])) {
            $this->generateReport();
        }
    }

    public function generateReport()
    {
        $this->revenues = $this->getAccountsByType('revenue');
        $this->expenses = $this->getAccountsByType('expense');

        $this->totalRevenue = collect($this->revenues)->sum('amount');
        $this->totalExpense = collect($this->expenses)->sum('amount');
        $this->netProfit = $this->totalRevenue - $this->totalExpense;
    }

    protected function getAccountsByType(string $type): array
    {
        return Account::where('type', $type)
            ->where('is_group', false)
            ->with(['journalEntryLines.journalEntry' => fn ($query) =>
                $query->where('posted', true)
                      ->whereBetween('date', [$this->startDate, $this->endDate])
            ])
            ->get()
            ->map(function ($account) use ($type) {
                $debit = $account->journalEntryLines->sum('debit');
                $credit = $account->journalEntryLines->sum('credit');

                $amount = $type === 'revenue'
                    ? $credit - $debit
                    : $debit - $credit;

                return [
                    'code' => $account->code,
                    'name' => $account->name,
                    'amount' => $amount,
                ];
            })
            ->filter(fn ($a) => $a['amount'] != 0)
            ->toArray();
    }
}
