<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AccountResource\Pages;
use App\Filament\Resources\AccountResource\RelationManagers;
use App\Models\Account;
//use BezhanSalleh\FilamentShield\Contracts\HasShieldPermissions;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AccountResource extends Resource
{
    protected static ?string $model = Account::class;

    protected static ?string $navigationIcon = 'heroicon-o-credit-card';
    protected static ?string $navigationGroup = 'Finance';
    protected static ?string $navigationLabel = 'Daftar Akun';
    protected static ?int $navigationSort = 10;



    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Card::make([
                    Forms\Components\TextInput::make('code')
                        ->label('Kode Akun')
                        ->required()
                        ->maxLength(20),

                    Forms\Components\TextInput::make('name')
                        ->label('Nama Akun')
                        ->required()
                        ->maxLength(100),

                    Forms\Components\Select::make('type')
                        ->label('Tipe Akun')
                        ->options([
                            'asset' => 'Aktiva',
                            'liability' => 'Pasiva',
                            'equity' => 'Ekuitas',
                            'revenue' => 'Pendapatan',
                            'expense' => 'Biaya',
                        ])
                        ->required()
                        ->native(false),

                    Forms\Components\Select::make('parent_id')
                        ->label('Akun Induk')
                        ->relationship('parent', 'name')
                        ->searchable()
                        ->preload()
                        ->nullable(),

                    Forms\Components\Toggle::make('is_group')
                        ->label('Merupakan Akun Grup?')
                        ->inline(),

                    Forms\Components\TextInput::make('opening_balance')
                        ->label('Saldo Awal')
                        ->numeric()
                        ->prefix('Rp')
                        ->default(0)
                        ->visible(fn ($get) => !$get('is_group')),
                ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('code')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('name')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('type')->badge(),
                Tables\Columns\TextColumn::make('parent.name')->label('Parent'),
            ])
            ->defaultSort('code')
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
            'index' => Pages\ListAccounts::route('/'),
            'create' => Pages\CreateAccount::route('/create'),
            'edit' => Pages\EditAccount::route('/{record}/edit'),
        ];
    }
}
