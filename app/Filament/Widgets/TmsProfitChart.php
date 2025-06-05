<?php
namespace App\Filament\Widgets;

use Filament\Widgets\BarChartWidget;
use App\Models\JournalEntryLine;
use App\Models\Account;
use Illuminate\Support\Carbon;

class TmsProfitChart extends BarChartWidget
{
    protected static ?string $heading = 'Laba Rugi Bulanan (6 Bulan Terakhir)';

    protected function getData(): array
    {
        $months = [];
        $revenues = [];
        $expenses = [];

        for ($i = 5; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            $months[] = $month->format('M Y');

            $start = $month->copy()->startOfMonth()->toDateString();
            $end = $month->copy()->endOfMonth()->toDateString();

            $revenue = $this->sumAccountTypeAmount('revenue', $start, $end);
            $expense = $this->sumAccountTypeAmount('expense', $start, $end);

            $revenues[] = $revenue;
            $expenses[] = $expense;
        }

        return [
            'labels' => $months,
            'datasets' => [
                [
                    'label' => 'Pendapatan',
                    'data' => $revenues,
                    'backgroundColor' => '#10b981', // hijau
                ],
                [
                    'label' => 'Pengeluaran',
                    'data' => $expenses,
                    'backgroundColor' => '#ef4444', // merah
                ],
            ],
        ];
    }

    protected function sumAccountTypeAmount(string $type, string $startDate, string $endDate): float
    {
        $accounts = Account::where('type', $type)->pluck('id')->toArray();

        if (empty($accounts)) {
            return 0;
        }

        $sumDebit = JournalEntryLine::whereIn('account_id', $accounts)
            ->whereHas('journalEntry', fn ($q) => $q->where('posted', true)->whereBetween('date', [$startDate, $endDate]))
            ->sum('debit');

        $sumCredit = JournalEntryLine::whereIn('account_id', $accounts)
            ->whereHas('journalEntry', fn ($q) => $q->where('posted', true)->whereBetween('date', [$startDate, $endDate]))
            ->sum('credit');

        // Revenue = credit - debit, Expense = debit - credit
        if ($type === 'revenue') {
            return $sumCredit - $sumDebit;
        } else {
            return $sumDebit - $sumCredit;
        }
    }
}