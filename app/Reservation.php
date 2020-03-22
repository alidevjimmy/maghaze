<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Reservation extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'cart_id' , 'user_id' , 'checked' , 'delivery_id' , 'market_id'
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }

    public function deliveries()
    {
        return $this->belongsTo(Delivery::class);
    }
}
