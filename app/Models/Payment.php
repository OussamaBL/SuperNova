<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;
    protected $fillable = [
        'num_order',
        'amount',
        'currency',
        'payment_status',
        'payment_method',
        'user_id',
    ];
}
