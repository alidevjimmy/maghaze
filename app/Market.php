<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Market extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'name',
        'lat',
        'long',
        'address',
        'active'
    ];
    public function products()
    {
        return $this->belongsToMany(Product::class);
    }

    public function deliveries()
    {
        return $this->hasMany(Delivery::class);
    }
}
