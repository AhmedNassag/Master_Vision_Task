<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    use HasFactory;

    protected $table   = 'shops';
    protected $guarded = [];
    

    
    //start relations
    public function shopProducts()
    {
        return $this->hasMany(ShopProduct::class, 'shop_id');
    }
}
