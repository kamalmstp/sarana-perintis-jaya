<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RentalPaymentResource\Pages;
use App\Filament\Resources\RentalPaymentResource\RelationManagers;
use App\Models\Rental;
use App\Models\RentalCosts;
use App\Models\RentalPayment;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\{Section, Grid, Hidden, Select, DatePicker, CheckboxList};
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class RentalPaymentResource extends Resource
{
    protected static ?string $model = RentalPayment::class;

    protected static ?string $navigationIcon = 'heroicon-o-receipt-percent';
    protected static ?string $navigationGroup = 'Finance';
    protected static ?string $label = 'Nota Pembayaran';
    protected static ?string $navigationLabel = 'Nota Pembayaran';
    protected static ?int $navigationSort = 8;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Section::make('Informasi Pembayaran')
                ->description('Isi data pemilik rental dan tanggal pembayaran.')
                ->schema([
                    Grid::make(2)->schema([
                        Hidden::make('receipt_number'),

                        Select::make('rental_id')
                            ->label('Pemilik Rental')
                            ->relationship('rental', 'name')
                            ->reactive()
                            ->required()
                            ->afterStateUpdated(fn ($state, callable $set) => $set('rental_costs', [])),

                        DatePicker::make('payment_date')
                            ->label('Tanggal Pembayaran')
                            ->required(),
                    ]),
                ])
                ->columns(1),

            Section::make('Pilih Truk Rental yang Akan Dibayar')
                ->description('Hanya truk rental yang belum pernah dibayarkan yang akan muncul.')
                ->schema([
                    CheckboxList::make('rental_costs')
                        ->label('Biaya Truk Rental')
                        ->options(function (callable $get) {
                            $rentalId = $get('rental_id');
                            if (!$rentalId) return [];

                            return \App\Models\RentalCosts::query()
                                ->where('rental_id', $rentalId)
                                ->whereDoesntHave('rentalPayments') // filter belum dibayar
                                ->with('orderDetail.trucks')
                                ->get()
                                ->mapWithKeys(function ($cost) {
                                    $truck = $cost->orderDetail->trucks->plate_number ?? '-';
                                    $driver = $cost->orderDetail->drivers->name ?? '-';
                                    $qty = number_format($cost->orderDetail->netto, 0, ',', '.') ?? 1;
                                    $tarif = number_format($cost->tarif_rental, 0, ',', '.');
                                    $total = number_format($cost->tarif_rental * $qty, 0, ',', '.');
                                    return [
                                        $cost->id => "($truck - $driver) | Qty: $qty Kg | Tarif: Rp $tarif | Total: Rp $total"
                                    ];
                                })->toArray();
                        })
                        ->columns(1)
                        ->searchable()
                        ->required(),
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('receipt_number')->label('No. Kwitansi')->searchable(),
                Tables\Columns\TextColumn::make('rental.name')->label('Pemilik Rental'),
                Tables\Columns\TextColumn::make('payment_date')->label('Tanggal'),
                Tables\Columns\TextColumn::make('total_amount')->label('Total')->money('IDR'),
            ])
            ->filters([
                //
            ])
            ->modifyQueryUsing(function ($query) {
                return $query->latest();
            })
            ->paginated()
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\DeleteAction::make(),

            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRentalPayments::route('/'),
            'create' => Pages\CreateRentalPayment::route('/create'),
            'view' => Pages\ViewRentalPayment::route('/{record}'),
        ];
    }
}
