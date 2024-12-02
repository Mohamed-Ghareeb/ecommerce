<?php

namespace App\Filament\Widgets;

use Filament\Tables;
use App\Models\Order;
use Filament\Tables\Table;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Actions\ActionGroup;
use App\Filament\Resources\OrderResource;
use Filament\Widgets\TableWidget as BaseWidget;

class LatestOrders extends BaseWidget
{
    protected int | string | array $columnSpan = 'full';
    protected static ?int $sort = 2;

    public function table(Table $table): Table
    {
        return $table
            ->query(OrderResource::getEloquentQuery())
            ->defaultPaginationPageOption(10)
            ->defaultSort('created_at', 'desc')
            ->columns([
                TextColumn::make('id')
                    ->label('Order ID')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('user.name')
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
            ->actions([
                ActionGroup::make([
                    ViewAction::make()->url(fn(Order $record): string => OrderResource::getUrl('view', ['record' => $record])),
                ]),
            ]);
    }
}
