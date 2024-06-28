<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PriceableResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    { 
        $price = $this->price;

        return array_merge(parent::toArray($request), [
            "price" => [
                "id" => $price->id,
                "unit_price_excl" => $price->unit_price_excl,
                "unit_price_incl" => $price->unit_price_incl,
            ]
        ]);
    }
}
