<?php

namespace App\Filament\Widgets;

use App\Models\Customer;
use App\Models\Product;
use App\Models\Transaction;
use Filament\Support\Colors\Color;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{

    protected static bool $isLazy = false;
    protected function getStats(): array
    {

        return [
            $this->buildTransactionsStat(),
            $this->buildCustomersStat(),
            $this->buildProductsStat()
        ];
    }

    private function buildTransactionsStat(): Stat
    {
        $transactions_count = Transaction::query()->count();
        $last_m_trans_count = Transaction::query()->whereMonth('created_at', date('m'))->count();

        return Stat::make('Transactions', $transactions_count)
                ->color(Color::Blue)
                ->description(sprintf("+%d this month", $last_m_trans_count))
                ->icon('heroicon-s-currency-dollar')
                ->chart([1, 2, 1.5, 3, 1, 5]);
    }

    private function buildCustomersStat(): Stat
    {
        $count = Customer::query()->count();
        $last_m_customer_count = Customer::query()->whereMonth('created_at', date('m'))->count();
        return Stat::make('Customers', $count)
            ->description(sprintf("+%d this month", $last_m_customer_count))
            ->chart([1, 2, 1.5, 3, 1, 5])
            ->icon('heroicon-s-users')
            ->color(Color::Orange);
    }

    private  function buildProductsStat(): Stat
    {
        $count = Product::query()->count();
        $last_m_product_count = Product::query()->whereMonth('created_at', date('m'))->count();
        return Stat::make('Products', $count)
            ->description(sprintf("+%d this month", $last_m_product_count))
            ->chart([1, 2, 1.5, 3, 1, 5])
            ->icon('heroicon-s-cube')
            ->color(Color::Green);

    }
}
