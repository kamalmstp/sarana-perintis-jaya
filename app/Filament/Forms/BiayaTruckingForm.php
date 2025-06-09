<?php

namespace App\Filament\Forms;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Radio;

class BiayaTruckingForm
{
    public static function make($record): array
    {
        $ownership = $record?->trucks?->ownership ?? null;
        if ($ownership === 'company') {
            return [
                TextInput::make('uang_sangu')
                    ->numeric()
                    ->prefix('Rp')
                    ->label('Uang Sangu'),

                TextInput::make('uang_jalan')
                    ->numeric()
                    ->prefix('Rp')
                    ->label('Uang Jalan'),

                TextInput::make('uang_bbm')
                    ->numeric()
                    ->prefix('Rp')
                    ->label('Uang BBM'),

                TextInput::make('uang_kembali')
                    ->numeric()
                    ->prefix('Rp')
                    ->label('Uang Kembali'),

                TextInput::make('gaji_supir')
                    ->numeric()
                    ->prefix('Rp')
                    ->label('Gaji Supir'),
            ];
        }

        return [
            TextInput::make('no_kwitansi')
                ->label('No Kwitansi'),
            
            TextInput::make('no_surat_jalan')
                ->label('No Surat Jalan'),

            Select::make('rental_id')
                ->label('Pemilik')
                ->relationship('rentalCost.rental', 'name')
                ->preload()
                ->searchable()
                ->createOptionForm([
                    TextInput::make('name')->label('Nama'),
                    TextInput::make('npwp')->label('NPWP'),
                ])
                ->nullable(),
                

            Radio::make('pph')
                ->label('Pajak')
                ->options([
                    '0.02' => 'NPWP',
                    '0.005' => 'SKB'
                ]),

            TextInput::make('tarif_rental')
                ->numeric()
                ->prefix('Rp')
                ->label('Tarif Rental'),
        ];
    }

    public static function fill($record): array
    {
        if ($record->trucks?->ownership === 'company'){
            return $record->driverCost
                ?
            $record->driverCost->only([
                'uang_sangu', 'uang_kembali','gaji_supir','uang_bbm','uang_jalan',
            ]): [];
        }

        return $record->rentalCost 
            ?
        $record->rentalCost->only([
            'tarif_rental', 'rental_id', 'no_kwitansi', 'no_surat_jalan', 'pph'
        ]) : [];
    }

    public static function save($data, $record): void
    {
        if ($record->trucks?->ownership === 'company') {
            
            $record->driverCost()->updateOrCreate([],$data);
        } else {
            $record->rentalCost()->updateOrCreate([],$data);
        }
        
    }
}