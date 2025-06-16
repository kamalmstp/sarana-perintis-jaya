use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;

return [
    Select::make('order_proses_id')
        ->label('Nomor DO')
        ->relationship('orderProses', 'no_do')
        ->searchable()
        ->required(),

    TextInput::make('kebun')
        ->label('Nama Kebun')
        ->required(),

    TextInput::make('qty')
        ->label('Qty (Kg)')
        ->numeric()
        ->required(),

    TextInput::make('tarif_per_kg')
        ->label('Tarif / Kg')
        ->numeric()
        ->prefix('Rp')
        ->required(),

    TextInput::make('total')
        ->label('Total Upah')
        ->disabled()
        ->dehydrated(false)
        ->reactive()
        ->afterStateHydrated(function ($component, $state, $record) {
            if ($record) {
                $component->state($record->qty * $record->tarif_per_kg);
            }
        })
        ->afterStateUpdated(function ($set, $get) {
            $set('total', (int)$get('qty') * (int)$get('tarif_per_kg'));
        }),
];