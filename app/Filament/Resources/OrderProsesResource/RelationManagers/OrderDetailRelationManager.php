<?php

namespace App\Filament\Resources\OrderProsesResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use App\Filament\Resources\OrderDetailResource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Infolists\Infolist;
use Filament\Notifications\Notification;

class OrderDetailRelationManager extends RelationManager
{
    protected static string $relationship = 'order_detail';
    protected static ?string $title = 'Truck';
    protected static ?string $label = 'Truck';
    protected static ?string $pluralLabel = 'Truck';
    

    public function form(Form $form): Form
    {
        return OrderDetailResource::form($form);
    }

    public function table(Table $table): Table
    {
        return OrderDetailResource::table($table)
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->label('New Data')
                    ->icon('heroicon-o-plus-circle')
                    ->fillForm(function (array $arguments): array {
                        return [
                            'order_proses_id'   => $this->getOwnerRecord()->id,
                        ];
                    })
                    ->successNotification(
                        Notification::make()
                            ->success(),
                    ),
            ]);
    }
}
