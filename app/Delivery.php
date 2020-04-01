<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Delivery extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'market_id',
        'name',
        'family',
        'phone',
        'melli_code',
        'address'
    ];

    public function market()
    {
        return $this->belongsTo(Market::class);
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }
}
