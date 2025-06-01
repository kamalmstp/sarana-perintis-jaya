<?php

namespace App\Filament\Resources\OrderResource\Pages;

use Filament\Actions;
use App\Filament\Resources\OrderResource;
use App\Filament\Resources\OrderProsesResource;
use App\Models\OrderProses;
use Filament\Resources\Pages\Page;
use Filament\Resources\Pages\ManageRelatedRecords;
use Filament\Forms\Form;
use Filament\Infolists\Infolist;
use Filament\Notifications\Notification;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;


class ManageOrderProses extends ManageRelatedRecords
{
    protected static string $resource = OrderResource::class;

    protected static string $relationship = 'order_proses';
    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-check';

    public static function getNavigationLabel(): string
    {
        return __('Order (DO/PO/SO)');
    }

    // protected function getHeaderActions(): array
    // {
    //     return [
    //         Actions\CreateAction::make()
    //             ->label('New Order')
    //             ->icon('heroicon-o-plus-circle')
    //             ->url(OrderProsesResource::getUrl('create')),
    //     ];
    // }

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
