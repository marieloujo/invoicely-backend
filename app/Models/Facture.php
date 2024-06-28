<?php

namespace App\Models;

use App\Traits\HasUser;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Facture extends Model
{
    use HasFactory, SoftDeletes, HasUuids, HasUser;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'client_id',
        'reference',
        'status',
        'total_amount_excl',
        'total_amount_incl',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'user_id',
        'client_id',
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
            'created_at' => 'date:d/m/Y',
        ];
    }

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = [
        'client'
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'total_amount_excl',
        'total_amount_incl'
    ];

    /**
     * Get the client that owns the Facture
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    /**
     * Get all of the items for the Facture
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function items(): HasMany
    {
        return $this->hasMany(FactureItem::class);
    }

    /**
     * Calculate the total amount taxe exclude
     */
    protected function totalAmountExcl(): Attribute
    {
        return new Attribute(
            get: fn () => $this->items()->sum('total_amount_excl'),
        );
    }

    /**
     * Calculate the total amount taxe indlude
     */
    protected function totalAmountIncl(): Attribute
    {
        return new Attribute(
            get: fn () => $this->items()->sum('total_amount_incl'),
        );
    }


    /**
     * 
     */
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            $model->user_id = auth('api')->id();
            $model->reference = generate_unique_invoice_number();
        });
    }
}
