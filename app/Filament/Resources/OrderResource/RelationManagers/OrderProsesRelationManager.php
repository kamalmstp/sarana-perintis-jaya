<?php

namespace App\Filament\Resources\OrderResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use App\Filament\Resources\OrderProsesResource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Infolists\Infolist;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Auth;

class OrderProsesRelationManager extends RelationManager
{
    protected static string $relationship = 'order_proses';
    protected static ?string $title = 'Order DO/PO/SO';
    protected static ?string $label = 'Order DO/PO/SO';
    protected static ?string $pluralLabel = 'Order DO/PO/SO';

    public function form(Form $form): Form
    {
        return OrderProsesResource::form($form);
    }

    public function table(Table $table): Table
    {
        return OrderProsesResource::table($table)
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->label('New Order')
                    ->icon('heroicon-o-plus-circle')
                    ->fillForm(function (array $arguments): array {
                        return [
                            'order_id'   => $this->getOwnerRecord()->id,
                        ];
                    })
                    ->modalWidth('6xl')
                    ->successNotification(
                        Notification::make()
                            ->success(),
                    ),
            ]);
    }
}
