<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order_Item extends Model
{
    protected $table = 'order_items';

    protected $fillable = [
        'quantity',
        'product_id',
        'order_id',
        'price'
    ];
    use HasFactory;
}
