<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LaborPaymentResource\Pages;
use App\Models\LaborPayment;
use App\Models\OrderProses;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Filament\Tables\Actions\Action;
use Filament\Tables;
use Illuminate\Support\Str;

class LaborPaymentResource extends Resource
{
    protected static ?string $model = LaborPayment::class;

    protected static ?string $navigationIcon = 'heroicon-o-receipt-percent';
    protected static ?string $navigationLabel = 'Nota Buruh';
    protected static ?string $navigationGroup = 'Finance';
    protected static ?string $pluralLabel = 'Nota Buruh';
    protected static ?string $modelLabel = 'Nota Buruh';
    protected static ?int $navigationSort = 8;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Informasi Pembayaran')
                ->schema([
                    Forms\Components\TextInput::make('receipt_number')
                        ->label('Nomor Kwitansi')
                        ->default(fn () => 'KW-BUR-' . strtoupper(Str::random(6)))
                        ->required(),

                    Forms\Components\DatePicker::make('payment_date')
                        ->label('Tanggal Pembayaran')
                        ->required(),
                ])->columns(2),

            Forms\Components\Section::make('Detail Pembayaran Buruh')
                ->description('Masukkan DO dan upah per kg.')
                ->schema([
                    Forms\Components\Repeater::make('details')
                        ->label('Daftar Pembayaran')
                        ->relationship()
                        ->schema([
                            Forms\Components\Select::make('order_proses_id')
                                ->label('Nomor DO / Tujuan')
                                ->relationship('orderProses', 'id')
                                ->searchable()
                                ->preload()
                                ->required(),

                            Forms\Components\TextInput::make('qty_kg')
                                ->label('Qty (Kg)')
                                ->numeric()
                                ->required(),

                            Forms\Components\TextInput::make('tarif_per_kg')
                                ->label('Tarif / Kg')
                                ->numeric()
                                ->required(),

                            Forms\Components\Placeholder::make('total')
                                ->label('Total')
                                ->content(function ($get) {
                                    $qty = (float) $get('qty_kg') ?: 0;
                                    $tarif = (float) $get('tarif_per_kg') ?: 0;
                                    return 'Rp ' . number_format($qty * $tarif, 0, ',', '.');
                                }),
                        ])
                        ->columns(3)
                        ->minItems(1)
                        ->createItemButtonLabel('Tambah DO'),
                ])
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('receipt_number')->label('No. Kwitansi')->searchable(),
                Tables\Columns\TextColumn::make('payment_date')->label('Tanggal')->date(),
                Tables\Columns\TextColumn::make('details_count')->label('Jumlah DO')->counts('details'),
                Tables\Columns\TextColumn::make('created_at')->label('Dibuat')->dateTime(),
            ])
            ->filters([])
            ->actions([
                Action::make('print')
                    ->label('Cetak Kwitansi')
                    ->icon('heroicon-m-printer')
                    ->color('gray')
                    ->url(fn ($record) => route('labor-payments.receipt', $record))
                    ->openUrlInNewTab(),
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListLaborPayments::route('/'),
            'create' => Pages\CreateLaborPayment::route('/create'),
            'edit' => Pages\EditLaborPayment::route('/{record}/edit'),
        ];
    }
}