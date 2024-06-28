<?php

namespace App\Models;

use App\Traits\HasUser;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Supply extends Model
{
    use HasFactory, SoftDeletes, HasUuids, HasUser;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'reception_clerk_id',
        'reference',
        'delivery_person',
        'status'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
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
            'created_at' => 'datetime:d/m/Y g:i A',
        ];
    }

    /**
     * Retreive transactionable's transactions
     *
     * @return Transaction
     */
    public function transactions()
    {
        return $this->morphMany(Transaction::class, 'transactionable')->latest();
    }


    /**
     * 
     */
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            $model->user_id = auth('api')->id();
            $model->reference = generate_unique_reference();
        });
    }
}
