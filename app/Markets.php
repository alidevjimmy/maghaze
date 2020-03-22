<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Markets extends Model
{
    use SoftDeletes;

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }

    public function deliveries()
    {
        return $this->hasMany(Delivery::class);
    }
}
