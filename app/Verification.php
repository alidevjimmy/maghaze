<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Verification extends Model
{
    use SoftDeletes;
    protected $fillable = ['used', 'user_id', 'code'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
