<?php

namespace App\Filament\Resources;

use Filament\GlobalSearch\Actions\Action;
use Illuminate\Contracts\Support\Htmlable;
use App\Filament\Resources\TruckResource\Pages;
use App\Filament\Resources\TruckResource\RelationManagers;
use App\Filament\Imports\TruckImporter;
use App\Models\Truck;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TruckResource extends Resource
{
    protected static ?string $model = Truck::class;

    protected static ?string $navigationIcon = 'heroicon-o-truck';
    protected static ?string $navigationGroup = 'Master Data';
    protected static ?string $navigationLabel = 'Daftar Truck';
    protected static ?int $navigationSort = 15;
    
    protected static ?string $recordTitleAttribute = 'truck';
    
    public static function getGloballySearchableAttributes(): array
    {
        return ['plate_number', 'notes'];
    }
    
    public static function getPermissionPrefixes(): array
    {
        return [
            'view',
            'view_any',
            'create',
            'update',
            'restore',
            'restore_any',
            'replicate',
            'reorder',
            'delete',
            'delete_any',
            'force_delete',
            'force_delete_any',
        ];
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('plate_number')
                    ->label('Nomor Polisi')
                    //->mask('aa #### aa')
                    ->placeholder('Contoh: KH1234XY')
                    ->required(),
                Forms\Components\Select::make('ownership')
                    ->label('Status Kepemilikan')
                    ->options([
                        'company' => 'Milik Perusahaan',
                        'rental' => 'Rental'
                      ])
                    ->default('company')
                    ->required(),
                Forms\Components\Textarea::make('notes')
                    ->label('Catatan')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('plate_number')
                    ->label('Nomor Polisi')
                    ->searchable(),
                Tables\Columns\TextColumn::make('ownership')
                    ->label('Status Kepemilikan')
                    ->badge()
                    ->colors([
                        'primary' => 'company',
                        'warning' => 'rental'
                      ]),
                Tables\Columns\TextColumn::make('notes')
                    ->label('Catatan'),
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
                //
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

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTrucks::route('/'),
            'create' => Pages\CreateTruck::route('/create'),
            'edit' => Pages\EditTruck::route('/{record}/edit'),
        ];
    }
}
