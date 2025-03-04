<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Benefit extends Model
{
    use HasFactory;

    protected $table = 'benefits';

    protected $fillable = [
        'inventory_id',
        'item_type',
        'item_id',
        'prebalance',
        'doc_id',
        'doc_type',
        'benefit',
    ];

    /**
     * Định nghĩa quan hệ với model Inventory (nếu có)
     */
    public function inventory()
    {
        return $this->belongsTo(Inventory::class);
    }

    /**
     * Định nghĩa quan hệ với model User, Vendor, Warehouse dựa vào item_type và item_id
     */
    // public function item()
    // {
    //     return match ($this->item_type) {
    //         'user' => $this->belongsTo(User::class, 'item_id'),
    //         'vendor' => $this->belongsTo(Vendor::class, 'item_id'),
    //         'wh' => $this->belongsTo(Warehouse::class, 'item_id'),
    //         default => null,
    //     };
    // }

    // /**
    //  * Định nghĩa quan hệ với tài liệu liên quan (Document, Invoice, v.v.)
    //  */
    // public function document()
    // {
    //     return $this->belongsTo(Document::class, 'doc_id');
    // }
}
