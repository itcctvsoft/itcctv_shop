<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryDetail extends Model
 {
    use HasFactory;

    protected $table = 'inventory_details';

    protected $fillable = [
        'inventory_id',
        'doc_type',
        'wh_id',
        'product_id',
        'quantity',
        'operation',
        'prebalance',
        'price',
        'doc_id',
        'expired_at',
        'benefit',
    ];

    /**
     * Quan hệ với bảng Inventory
     */
    public function inventory()
    {
        return $this->belongsTo(Inventory::class, 'inventory_id');
    }

    /**
     * Quan hệ với Warehouse (Kho hàng)
     */
    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class, 'wh_id');
    }

    /**
     * Quan hệ với Product (Sản phẩm)
     */
    // public function product()
    // {
    //     return $this->belongsTo(Product::class, 'product_id');
    // }

    // /**
    //  * Quan hệ với Document (Tài liệu liên quan)
    //  */
    public function document()
    {
        if($this->doc_type == 'wi' || $this->doc_type == 'wir')
        {
            $wi = \App\Models\Warehousein::find($this->doc_id);
            return $wi;
        }
        if($this->doc_type == 'wo' || $this->doc_type == 'wor')
        {
            $wo = \App\Models\WarehouseOut::find($this->doc_id);
            return $wo;
        }
        if($this->doc_type == 'din')
        {
            $wi = \App\Models\Din::find($this->doc_id);
            return $wi;
        }
        if($this->doc_type == 'dout')
        {
            $wo = \App\Models\DOut::find($this->doc_id);
            return $wo;
        }
        return null;
    }
}
