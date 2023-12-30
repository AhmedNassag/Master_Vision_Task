<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'sales';
    protected $guarded = [];

    //start relations
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function sale_details()
    {
        return $this->hasMany(Sale_Detail::class);
    }
}
