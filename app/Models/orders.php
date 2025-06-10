<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class orders extends Model
{
    //
    protected $primaryKey = 'id';
    protected $fillable = [
        'car_id',
        'order_date',
        'pickup_date',
        'pickup_location',
        'dropoff_date',
        'dropoff_location',
    ];

    public function car(): BelongsTo
    {
        return $this->belongsTo(cars::class, 'car_id');
    }

}
