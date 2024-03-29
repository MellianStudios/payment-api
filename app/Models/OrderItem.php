<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperOrderItem
 */
class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'price_id',
        'discount_id',
    ];
}
