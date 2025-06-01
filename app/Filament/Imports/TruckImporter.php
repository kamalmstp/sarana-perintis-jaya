<?php

namespace App\Filament\Imports;

use App\Models\Truck;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;

class TruckImporter extends Importer
{
    protected static ?string $model = Truck::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('plate_number')
                ->requiredMapping()
                ->rules(['required', 'max:255']),
            ImportColumn::make('ownership')
                ->requiredMapping()
                ->rules(['required']),
        ];
    }

    public function resolveRecord(): ?Truck
    {
        return Truck::firstOrNew([
            // Update existing records, matching them by `$this->data['column_name']`
            'plate_number' => $this->data['plate_number'],
            'ownership' => $this->data['ownership'],
        ]);

        //return new Truck();
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Your truck import has completed and ' . number_format($import->successful_rows) . ' ' . str('row')->plural($import->successful_rows) . ' imported.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to import.';
        }

        return $body;
    }
}
