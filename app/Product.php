<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'name',
        'price',
        'rate',
        'sell_count',
        'category_id'
    ];
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function markets()
    {
        return $this->belongsToMany(Market::class);
    }

    public function image()
    {
        return $this->morphOne(Image::class , 'imageable');
    }
}
