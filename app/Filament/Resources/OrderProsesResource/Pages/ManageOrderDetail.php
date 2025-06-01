<?php

namespace App\Filament\Resources\OrderProsesResource\Pages;

use App\Filament\Resources\OrderProsesResource;
use App\Filament\Resources\OrderDetailResource;
use App\Models\OrderDetail;
use Filament\Actions;
use Filament\Forms\Form;
use Filament\Infolists\Infolist;
use Filament\Notifications\Notification;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Filament\Resources\Pages\ManageRelatedRecords;

class ManageOrderDetail extends ManageRelatedRecords
{
    protected static string $resource = OrderProsesResource::class;
    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';
    protected static string $relationship = 'order_detail';

    //customize redirect after create
    // public function getRedirectUrl(): string
    // {
    //     return $this->getResource()::getUrl('index');
    // }

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

    public static function getNavigationLabel(): string
    {
        return 'Trucking';
    }
}
