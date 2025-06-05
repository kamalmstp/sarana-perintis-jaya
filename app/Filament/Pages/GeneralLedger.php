<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Filament\Forms;
use Illuminate\Support\Facades\DB;
use App\Models\Account;
use Filament\Forms\Components\{Select, DatePicker};
use Filament\Forms\Concerns\InteractsWithForms;
use BezhanSalleh\FilamentShield\Traits\HasPageShield;

class GeneralLedger extends Page
{
    use InteractsWithForms, HasPageShield;

    protected static ?string $navigationIcon = 'heroicon-o-book-open';
    protected static ?string $title = 'Buku Besar';
    protected static string $view = 'filament.pages.general-ledger';
    protected static ?string $navigationGroup = 'Report';
    protected static ?int $navigationSort = 11;

    public ?int $account_id = null;
    public ?string $start_date = null;
    public ?string $end_date = null;

    public $entries = [];

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
        $this->start_date = now()->startOfMonth()->toDateString();
        $this->end_date = now()->toDateString();
    }

    public function getFormSchema(): array
    {
        return [
            Select::make('account_id')
                ->label('Pilih Akun')
                ->options(Account::orderBy('code')->pluck('name', 'id'))
                ->searchable()
                ->required(),

            DatePicker::make('start_date')
                ->label('Dari Tanggal')
                ->required(),

            DatePicker::make('end_date')
                ->label('Sampai Tanggal')
                ->required(),
        ];
    }

    public function loadData(): void
    {
        $this->entries = DB::table('journal_entry_lines as l')
            ->join('journal_entries as j', 'j.id', '=', 'l.journal_entry_id')
            ->where('l.account_id', $this->account_id)
            ->where('j.posted', true)
            ->whereDate('j.date', '>=', $this->start_date)
            ->whereDate('j.date', '<=', $this->end_date)
            ->select(
                'j.date',
                'j.description',
                'l.debit',
                'l.credit'
            )
            ->orderBy('j.date')
            ->get()
            ->toArray();
    }
}