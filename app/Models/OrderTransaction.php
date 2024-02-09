<?php

namespace App\Models;

use App\Enums\TransactionStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperOrderTransaction
 */
class OrderTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'provider',
        'status',
    ];

    protected $casts = [
        'status' => TransactionStatus::class,
    ];
}
