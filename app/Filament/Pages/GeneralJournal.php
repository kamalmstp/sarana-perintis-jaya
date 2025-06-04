<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Illuminate\Support\Facades\DB;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Concerns\InteractsWithForms;

class GeneralJournal extends Page
{
    use InteractsWithForms;

    protected static ?string $title = 'Jurnal Umum';
    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';
    protected static string $view = 'filament.pages.general-journal';
    protected static ?string $navigationGroup = 'Report';
    protected static ?int $navigationSort = 12;

    public ?string $startDate = null;
    public ?string $endDate = null;

    public array $journals = [];

    public function mount(): void
    {
        $this->startDate = now()->startOfMonth()->toDateString();
        $this->endDate = now()->toDateString();
        $this->loadData();
    }

    public function getFormSchema(): array
    {
        return [
            DatePicker::make('startDate')
                ->label('Dari Tanggal')
                ->required(),

            DatePicker::make('endDate')
                ->label('Sampai Tanggal')
                ->required(),
        ];
    }

    public function loadData(): void
    {
        $entries = DB::table('journal_entries as j')
            ->join('journal_entry_lines as l', 'l.journal_entry_id', '=', 'j.id')
            ->join('accounts as a', 'a.id', '=', 'l.account_id')
            ->where('j.posted', true)
            ->whereDate('j.date', '>=', $this->startDate)
            ->whereDate('j.date', '<=', $this->endDate)
            ->orderBy('j.date')
            ->orderBy('j.id')
            ->select('j.id as journal_id', 'j.date', 'j.description', 'a.name as account_name', 'l.debit', 'l.credit')
            ->get()
            ->groupBy('journal_id')
            ->toArray();

        $this->journals = $entries;
    }
}