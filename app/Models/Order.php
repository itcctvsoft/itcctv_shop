<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable = ['wh_id', 'customer_id', 'vendor_id','final_amount','discount_amount','paid_amount','is_paid','suptrans_id','paidtrans_id','shiptrans_id','delivery_id','cost_extra'];

    public function details()
    {
        
        $subquery = \App\Models\Product::select('id','title');
        $details = \App\Models\OrderDetail::where('wo_id', $this->id)
            ->joinSub($subquery, 'products', function ($join) {
                $join->on('order_details.product_id', '=', 'products.id');
            })
            ->select(
                'order_details.*', 
                'products.title', 
            )
            ->get();
         
        return $details;
    }
}
