<?php

namespace App\Filament\Widgets;

use App\Models\Product;
use Filament\Widgets\ChartWidget;

class TotalProfit extends ChartWidget
{
    protected static ?string $heading = 'Profit';

    protected static bool $isLazy = false;

    protected static ?string $pollingInterval = "20s";

    protected function getData(): array
    {

        $startDate = now()->subDays(28)->startOfDay();
        $endDate = now()->endOfDay();

        $profits = Product::with(['importTransactions', 'transactions'])
            ->get()
            ->flatMap(function ($product) {
                return $product->transactions->groupBy(function ($transaction) {
                    return $transaction->created_at->toDateString();
                })->map(function ($dailyTransactions, $date) use ($product) {
                    $totalSellPrice = $dailyTransactions->reduce(function ($carry, $transaction) {
                        return $carry + $transaction->pivot->sell_price * $transaction->pivot->quantity;
                    }, 0);
                    $totalBuyPrice = $product->importTransactions
                        ->avg('buy_price') * $dailyTransactions->sum('pivot.quantity');

                    return [
                        'date' => $date,
                        'profit' => $totalSellPrice - $totalBuyPrice
                    ];
                });
            })
            ->groupBy('date')
            ->map(function ($dailyProfits, $date) {
                return [
                    'date' => $date,
                    'profit' => $dailyProfits->sum('profit'),
                ];
            })
            ->sortBy('date');


        return [
            'datasets' => [
                [
                    'label' => 'Daily Profit',
                    'data' => $profits->pluck('profit')->values()->toArray(),
                ],
            ],
            'labels' => $profits->pluck('date')->values()->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
