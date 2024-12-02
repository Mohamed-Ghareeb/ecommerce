<?php

namespace App\Filament\Resources\UserResource\RelationManagers;

use App\Filament\Resources\OrderResource;
use App\Models\Order;
use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Columns\SelectColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Resources\RelationManagers\RelationManager;

class OrdersRelationManager extends RelationManager
{
    protected static string $relationship = 'orders';

    public function form(Form $form): Form
    {
        return $form
            ->schema([]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('id')
            ->columns([
                TextColumn::make('id')
                    ->label('Order ID')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('status')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'new' => 'gray',
                        'processing' => 'info',
                        'shipped' => 'warning',
                        'delivered' => 'success',
                        'cancelled' => 'danger',
                    })
                    ->icon(fn(string $state): string => match ($state) {
                        'new' => 'heroicon-m-sparkles',
                        'processing' => 'heroicon-m-arrow-path',
                        'shipped' => 'heroicon-m-truck',
                        'delivered' => 'heroicon-m-check-circle',
                        'cancelled' => 'heroicon-m-x-circle',
                    })
                    ->sortable()
                    ->searchable(),

                TextColumn::make('grand_total')
                    ->numeric()
                    ->money(fn($record) => $record->currency ?? 'egp')
                    ->sortable(),

                TextColumn::make('payment_method')
                    ->sortable()
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'stripe' => 'success',
                        'cod' => 'warning',
                    })
                    ->searchable(),

                TextColumn::make('payment_status')
                    ->sortable()
                    ->badge()
                    ->searchable(),

                TextColumn::make('shipping_method')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->headerActions([])
            ->actions([
                ActionGroup::make([
                    ViewAction::make()->url(fn(Order $record): string => OrderResource::getUrl('view', ['record' => $record])),
                    DeleteAction::make(),
                ])
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
