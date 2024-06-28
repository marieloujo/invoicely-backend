<?php

namespace App\Services;

use App\Repositories\ProductRepository;
use App\Services\Interfaces\ProductServiceInterface;

class ProductService extends PriceableService implements ProductServiceInterface
{

    /**
     * ProductService constructor.
     *
     * @param ProductRepository $productRepository
     */
    public function __construct(ProductRepository $productRepository)
    {
        parent::__construct($productRepository);
    }

}
