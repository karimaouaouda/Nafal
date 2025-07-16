<?php

namespace App\Services;

use App\Models\Transaction;
use http\Exception\BadMethodCallException;
use function Pest\Laravel\instance;

class TransactionService
{
    protected Transaction|null $transaction = null;


    public function __construct(?Transaction $transaction)
    {
        $this->transaction = $transaction;
    }


    public function use(Transaction $transaction): static
    {
        $this->transaction = $transaction;
        return $this;
    }

    public function getTransaction(): Transaction
    {
        return $this->transaction;
    }

    public function profit(): float
    {
        if( ! instance(Transaction::class, $this->transaction) ){
            throw new BadMethodCallException('call profit function in service without transaction instance');
        }

        $products = $this->transaction->products()->with('importTransactions')->get();
        $profit = 0;

        $products->each(function($product) use ($profit){
            $buy_price_avg = $product->importTransactions->avg('buy_price');

            $sell_price = $product->pivot->sell_price;
            $profit += ($sell_price - $buy_price_avg) * $product->pivot->quantity;
        });

        return $profit;
    }


}
