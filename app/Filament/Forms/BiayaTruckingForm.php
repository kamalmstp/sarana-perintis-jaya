<?php

namespace App\Filament\Forms;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;

class BiayaTruckingForm
{
    public static function make($record): array
    {
        if ($record->trucks?->ownership === 'company') {
            return [
                TextInput::make('uang_sangu')
                    ->numeric()
                    ->label('Uang Sangu'),

                TextInput::make('uang_kembali')
                    ->numeric()
                    ->label('Uang Kembali'),

                TextInput::make('gaji_supir')
                    ->numeric()
                    ->label('Gaji Supir'),

                TextInput::make('uang_bbm')
                    ->numeric()
                    ->label('Uang BBM'),

                TextInput::make('uang_jalan')
                    ->numeric()
                    ->label('Uang Jalan'),
            ];
        }

        return [
            TextInput::make('tarif_rental')
                ->numeric()
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
            'tarif_rental'
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