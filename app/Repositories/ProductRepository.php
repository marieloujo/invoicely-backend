<?php

namespace App\Repositories;

use App\Models\Product;
use Core\Repository\BaseRepository;

class ProductRepository extends BaseRepository
{

   /**
    * ProductRepository constructor.
    *
    * @param Product $product
    */
    public function __construct(Product $product)
    {
        parent::__construct($product);
    }

}
