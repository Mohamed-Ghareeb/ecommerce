<?php

namespace App\Filament\Resources\OrderResource\Widgets;

use App\Models\Order;
use Illuminate\Support\Number;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class OrderStats extends BaseWidget
{
    protected function getStats(): array
    {
        // Fetch counts grouped by status in a single query
        $statusCounts = Order::selectRaw('status, COUNT(*) as count')
        ->whereIn('status', ['new', 'processing', 'cancelled', 'shipped', 'delivered'])
        ->groupBy('status')
        ->pluck('count', 'status')
        ->toArray();
        

        return [
            Stat::make('New Orders', $statusCounts['new'] ?? 0),
            Stat::make('Processing Orders', $statusCounts['processing'] ?? 0),
            Stat::make('Cancelled Orders', $statusCounts['cancelled'] ?? 0),
            Stat::make('Shipped Orders', $statusCounts['shipped'] ?? 0),
            Stat::make('Delivered Orders', $statusCounts['delivered'] ?? 0),
            Stat::make('Average Price', Number::currency(Order::avg('grand_total'), 'EGP')),
        ];
    }
}
