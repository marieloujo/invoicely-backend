<?php

namespace App\Services;

use App\Enums\TypeTransaction;
use App\Models\Product;
use App\Models\Transaction;
use App\Services\Interfaces\TransactionServiceInterface;
use Illuminate\Database\Eloquent\Model;

class TransactionService implements TransactionServiceInterface
{

    /**
     * Storage a new transaction
     *
     * @param Model $transactionable
     * @param Product $product
     * @param TypeTransaction $type
     * @param float $quantity
     * @return Transaction
     */
    public function store(Model $transactionable, Product $product, TypeTransaction $type, float $quantity) : Transaction
    {
        $transaction = Transaction::create([
            'type'   => $type->value,
            'status'   => TRUE,
            'quantity'   => $quantity,
            'product_id'   => $product->id,
            'transactionable_id'      => $transactionable->id,
            'transactionable_type'    => get_class($transactionable),
        ]);

        $type === TypeTransaction::STORAGE
            ? $product->increment('stock', $quantity)
            : $product->decrement('stock', $quantity);

        return $transaction;
    }
}
