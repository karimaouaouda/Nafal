<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;

class TransactionsAmount extends ChartWidget
{
    protected static ?string $heading = 'Transactions';

    protected static bool $isLazy = false;

    protected function getData(): array
    {

        $data = [
            'datasets' => [
                [
                    'label' => 'Import Transactions',
                    'data' => \App\Models\ImportTransaction::query()
                        ->whereBetween('created_at', [now()->subDays(30), now()])
                        ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
                        ->groupBy('date')
                        ->pluck('count', 'date')
                        ->toArray(),
                    'borderColor' => '#4F46E5',
                    'backgroundColor' => '#4F46E5',
                ],
                [
                    'label' => 'Transactions',
                    'data' => \App\Models\Transaction::query()
                        ->whereBetween('created_at', [now()->subDays(30), now()])
                        ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
                        ->groupBy('date')
                        ->pluck('count', 'date')
                        ->toArray(),
                    'borderColor' => '#10B981',
                    'backgroundColor' => '#10B981',
                ],
            ],
            'labels' => \App\Models\Transaction::query()
                ->whereBetween('created_at', [now()->subDays(30), now()])
                ->selectRaw('DATE(created_at) as date')
                ->groupBy('date')
                ->pluck('date')
                ->toArray(),
        ];

        return $data;
    }

    protected function getType(): string
    {
        return 'line';
    }
}
