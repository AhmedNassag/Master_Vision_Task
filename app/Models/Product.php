<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table   = 'products';
    protected $guarded = [];



    //start relations
    public function media()
    {
        return $this->morphOne(Media::class, 'mediable');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
    
    public function shopProducts()
    {
        return $this->hasMany(ShopProduct::class, 'product_id');
    }



    public function sale_details()
    {
        return $this->hasMany(Sale_Detail::class);
    }
}
