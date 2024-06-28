<?php

namespace App\Services\Interfaces;

use App\Enums\TypeTransaction;
use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Database\Eloquent\Model;

/**
* Interface TransactionServiceInterface
* @package App\Services\Interfaces
*/
interface TransactionServiceInterface
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
    public function store(Model $transactionable, Product $product, TypeTransaction $type, float $quantity) : Transaction;

}
