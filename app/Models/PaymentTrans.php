<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentTrans extends Model
{
    use HasFactory;

    protected $table = 'payment_trans';

    protected $fillable = [
        'gateway',
        'account_number',
        'sub_account',
        'amount_in',
        'amount_out',
        'code',
        'transaction_content',
        'reference_number',
        'body',
        'transaction_date',
        'order_id',
    ];
}
