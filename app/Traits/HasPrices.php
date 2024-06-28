<?php

namespace App\Traits;

use App\Models\Price;

trait HasPrices
{
/**
 * The function retrieves the prices associated with a priceable item.
 * 
 * @return The `prices()` method is returning a collection of prices associated with the `priceable`
 * model. The prices are retrieved using the `morphMany` relationship and are sorted in descending
 * order based on the creation timestamp, with the latest price appearing first in the collection.
 */

    /**
     * Retreive priceable's prices
     *
     * @return Price
     */
    public function prices()
    {
        return $this->morphMany(Price::class, 'priceable')->latest();
    }

    /**
     * Retreive priceable's current price
     *
     * @return Price
     */
    public function price()
    {
        return $this->morphOne(Price::class, 'priceable')->where("status", TRUE);
    }

    /**
     * 
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->user_id = auth('api')->id();
        });

        static::saving(function ($model) {
            $model->slug = sluglify($model->designation);
        });
    }

}