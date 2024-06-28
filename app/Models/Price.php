<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Price extends Model
{
    use HasFactory, SoftDeletes, HasUuids;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'priceable_id',
        'priceable_type',
        'unit_price_excl',
        'unit_price_incl',
        'start_date',
        'end_date',
        'status'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'priceable_id',
        'priceable_type',
        'updated_at',
        'deleted_at',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'id'         => 'string',
            'start_date'  => 'datetime:d/m/Y',
            'end_date'  => 'datetime:d/m/Y',
            'created_at' => 'datetime:d/m/Y g:i A',
        ];
    }

    /**
     * Retreive price's owner
     *
     * @return Product|Service
     */
    public function priceable()
    {
        return $this->morphTo();
    }

    /**
     * 
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->start_date = now();
        });
    }

}
