<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class cars extends Model
{
    //
    protected $primaryKey = 'car_id';
    protected $fillable = [
        'car_name',
        'day_rate',
        'month_rate',
        'image',
    ];

     public function order(): HasMany
    {
        return $this->hasMany(orders::class, 'car_id');
    }
}
