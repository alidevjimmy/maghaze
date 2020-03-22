<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cart extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'user_id',
        'trashed'
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
