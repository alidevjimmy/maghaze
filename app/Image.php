<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Image extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'name' , 'url' , 'imageable_type' , 'imageable_id'
    ];
    public function imageable()
    {
        return $this->morphTo();
    }
}
