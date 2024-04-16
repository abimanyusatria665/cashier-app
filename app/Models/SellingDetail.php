<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SellingDetail extends Model
{
    use HasFactory;
    protected $fillable = [
        'product_id',
        'selling_id',
        'subtotal',
        'total_product'
    ];

    public function selling(){
        return $this->belongsTo(Selling::class);
    }

    public function product(){
        return $this->belongsTo(Product::class);
    }
}
