<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Concerns\InteractsWithForms;
use BezhanSalleh\FilamentShield\Traits\HasPageShield;

class BalanceSheet extends Page
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-banknotes';
    protected static string $view = 'filament.pages.balance-sheet';
    protected static ?string $title = 'Laporan Neraca';
    protected static ?string $navigationGroup = 'Report';
    protected static ?int $navigationSort = 10;

    public ?string $endDate = null;

    public $assets = [];
    public $liabilities = [];
    public $equity = [];

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
        $this->endDate = now()->toDateString();
        $this->loadData();
    }

    public function getFormSchema(): array
    {
        return [
            DatePicker::make('endDate')
                ->label('Periode s.d. Tanggal')
                ->required()
                ->default(now()),
        ];
    }

    public function loadData(): array
    {
        $endDate = $this->endDate;

        $balances = DB::table('journal_entry_lines as l')
            ->join('journal_entries as j', 'j.id', '=', 'l.journal_entry_id')
            ->join('accounts as a', 'a.id', '=', 'l.account_id')
            ->select(
                'a.id',
                'a.name',
                'a.type',
                DB::raw('SUM(l.debit) as total_debit'),
                DB::raw('SUM(l.credit) as total_credit')
            )
            ->where('j.posted', true)
            ->whereDate('j.date', '<=', $endDate)
            ->whereIn('a.type', ['asset', 'liability', 'equity'])
            ->groupBy('a.id', 'a.name', 'a.type')
            ->orderBy('a.code')
            ->get()
            ->map(function ($row) {
                $row->balance = $row->total_debit - $row->total_credit;
                if (in_array($row->type, ['liability', 'equity'])) {
                    $row->balance = -$row->balance;
                }
                return $row;
            });

        return [
            'assets' => $balances->where('type', 'asset'),
            'liabilities' => $balances->where('type', 'liability'),
            'equity' => $balances->where('type', 'equity'),
        ];
    }
}