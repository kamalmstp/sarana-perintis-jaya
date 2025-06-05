<?php
namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Card;
use App\Models\Order;
use App\Models\OrderProses;
use App\Models\OrderDetail;
use App\Models\JournalEntryLine;
use App\Models\Account;
use Illuminate\Support\Carbon;

class TmsStatsOverview extends StatsOverviewWidget
{
    protected function getCards(): array
    {
        $totalOrders = Order::count();
        $totalOrderProses = OrderProses::count();
        $totalOrderDetails = OrderDetail::count();

        // Hitung saldo kas & bank dari journal entry lines yang sudah diposting
        $cashBalance = $this->calculateAccountBalance('kas');
        $bankBalance = $this->calculateAccountBalance('bank');

        // Total jurnal yang sudah diposting
        $totalJournals = \App\Models\JournalEntry::where('posted', true)->count();

        return [
            Card::make('Total Order', $totalOrders),
            Card::make('Total Order Proses', $totalOrderProses),
            Card::make('Total Order Detail', $totalOrderDetails),
            Card::make('Saldo Kas', 'Rp ' . number_format($cashBalance, 0, ',', '.')),
            Card::make('Saldo Bank', 'Rp ' . number_format($bankBalance, 0, ',', '.')),
            Card::make('Total Jurnal Posting', $totalJournals),
        ];
    }

    protected function calculateAccountBalance(string $keyword): float
    {
        $accounts = Account::where('type', 'asset')
            ->where('name', 'like', "%$keyword%")
            ->pluck('id')
            ->toArray();

        if (empty($accounts)) {
            return 0;
        }

        // Hitung saldo dari journal entry lines untuk akun tersebut, yg posted dan sampai hari ini
        $debit = JournalEntryLine::whereIn('account_id', $accounts)
            ->whereHas('journalEntry', fn ($q) => $q->where('posted', true)->whereDate('date', '<=', now()))
            ->sum('debit');

        $credit = JournalEntryLine::whereIn('account_id', $accounts)
            ->whereHas('journalEntry', fn ($q) => $q->where('posted', true)->whereDate('date', '<=', now()))
            ->sum('credit');

        return $debit - $credit;
    }
}