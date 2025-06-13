class RentalCostResource extends Resource
{
    protected static ?string $model = RentalCost::class;

    public static function getTabs(): array
    {
        return [
            'all' => Tab::make('Semua'),
            'belum' => Tab::make('Belum Diisi')
                ->modifyQueryUsing(fn (Builder $query) => 
                    $query->whereNull('tarif_rental')
                ),
            'sudah' => Tab::make('Sudah Diisi')
                ->modifyQueryUsing(fn (Builder $query) => 
                    $query->whereNotNull('tarif_rental')
                ),
        ];
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('orderDetail.id')->label('Order Detail ID'),
                TextColumn::make('tarif_rental')->label('Tarif')->money('IDR', true),
                TextColumn::make('no_kwitansi'),
                TextColumn::make('status')->badge(),
            ]);
    }
}