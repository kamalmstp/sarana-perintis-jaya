use App\Models\Truck;
use Filament\Tables\Filters\Filter;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

public static function table(Table $table): Table
{
    return $table
        ->columns([
            Tables\Columns\TextColumn::make('date')
                ->label('Tanggal')
                ->date()
                ->sortable(),

            Tables\Columns\TextColumn::make('name')
                ->label('Nama Item')
                ->searchable(),

            Tables\Columns\TextColumn::make('trucks.plate_number')
                ->label('No Polisi')
                ->searchable()
                ->sortable(),

            Tables\Columns\TextColumn::make('qty')
                ->label('Jumlah')
                ->numeric()
                ->sortable(),

            Tables\Columns\TextColumn::make('price')
                ->label('Harga')
                ->formatStateUsing(fn ($state) => 'Rp ' . number_format($state, 0, ',', '.'))
                ->sortable(),

            Tables\Columns\TextColumn::make('jumlah')
                ->label('Total')
                ->getStateUsing(fn ($record) => 'Rp ' . number_format($record->price * $record->qty, 0, ',', '.'))
                ->sortable(),

            Tables\Columns\TextColumn::make('created_at')
                ->dateTime()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),

            Tables\Columns\TextColumn::make('updated_at')
                ->dateTime()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
        ])
        ->filters([
            // Tombol "Semua"
            Filter::make('all')
                ->label('Semua')
                ->query(fn ($query) => $query),

            // Tombol-tombol filter untuk truck yang ownership-nya "company"
            ...Truck::where('ownership', 'company')
                ->pluck('plate_number', 'id')
                ->map(function ($plateNumber, $id) {
                    return Filter::make('truck_' . $id)
                        ->label($plateNumber)
                        ->query(fn ($query) => $query->where('truck_id', $id));
                })
                ->values()
                ->all(),
        ])
        ->actions([
            Tables\Actions\EditAction::make(),
            Tables\Actions\DeleteAction::make(),
        ])
        ->bulkActions([
            Tables\Actions\BulkActionGroup::make([
                Tables\Actions\DeleteBulkAction::make(),
            ]),
        ]);
}