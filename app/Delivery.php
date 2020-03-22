<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Delivery extends Model
{
    use SoftDeletes;

    public function market()
    {
        return $this->belongsTo(Markets::class);
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }
}
