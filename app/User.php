<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name' , 'family' , 'active', 'phone', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];


    public function locations()
    {
        return $this->hasMany(Location::class);
    }

    public function carts()
    {
        return $this->hasMany(Cart::class);
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    public function verifications()
    {
        return $this->hasMany(Verification::class);
    }

}
