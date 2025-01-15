<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderTrans extends Model
{
    use HasFactory;

    protected $table = 'order_trans';

    protected $fillable = [
        'code',
        'item_code',
        'price',
        'status',
        'order_id',
    ];
}
