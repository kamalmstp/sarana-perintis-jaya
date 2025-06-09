use pxlrbt\FilamentExcel\Actions\Tables\ExportAction;

public static function table(Table $table): Table
{
    return $table
        ->columns([
            TextColumn::make('id'),
            TextColumn::make('customer_name'),
            TextColumn::make('status'),
            TextColumn::make('total'),
            TextColumn::make('created_at')->dateTime(),
        ])
        ->headerActions([
            ExportAction::make()
                ->label('Export Excel')
                ->fileName(fn () => 'orders-' . now()->format('Ymd_His'))
                ->exportFormat(\Maatwebsite\Excel\Excel::XLSX),
        ]);
}