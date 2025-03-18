<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Warehouseout extends Model
{
    use HasFactory;
    protected $fillable = ['code','uiid','version','wh_id', 'customer_id', 'vendor_id','final_amount','discount_amount','paid_amount','is_paid','suptrans_id',
    'paidtrans_id','shiptrans_id','delivery_id','cost_extra','status','is_global','returned_ids','debtbefore','debtafter','bankpayment'];
    public static function c_create($data)
    {
        $mw = Warehouseout::create($data);
        $mw->code = "WOU" . sprintf('%09d',$mw->id);
        $mw->save();
        \App\Models\Systrans::add_warehouseout($mw->id,$mw->final_amount,1);
        return $mw;
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function loaiphieu()
    {
        if($this->status =='returned')
            return 'Phiếu trả hàng nhập';
        if($this->status =='active')
            return 'Phiếu nhập hàng';
        return '';
    }
    public function details()
    {
        $doc_type = 'wo';
        if($this->status == 'returned')
            $doc_type = 'wor';
        
        $subquery = \App\Models\Product::select('id','title');
        $details = \App\Models\WarehouseoutDetail::where('wo_id', $this->id)
            ->where('doc_type', $doc_type)
            ->where('is_deleted', 0)
            ->joinSub($subquery, 'products', function ($join) {
                $join->on('warehouseout_details.product_id', '=', 'products.id');
            })
            ->select(
                'warehouseout_details.*', 
                'products.title', 
              
            )
            ->get();
        foreach ($details as $wi )
        {
            $series = "";
            $i = 0;
            $wo_seris = \DB::select("select seri from warehouseout_detail_series where (doc_type='wo' or doc_type='wor') and wo_id =".$wi->wo_id ." and product_id = ".$wi->product_id );
            foreach($wo_seris as $wo_seri)
            {
                if ($i > 0)
                    $series .= ",";
                $series .= $wo_seri->seri;
                $i ++;
            }
            $wi->series = $series;
        }
        return $details;
    }

    public static function log_change($warehouseout)
    {
        $data['outid'] = $warehouseout->id;
        $data['code'] = $warehouseout->code;
        $data['version'] = $warehouseout->version;
        $data['wh_id'] = $warehouseout->wh_id;
        $data['customer_id'] = $warehouseout->customer_id;
        $data['vendor_id'] = $warehouseout->vendor_id;
        $data['final_amount'] = $warehouseout->final_amount;
        $data['discount_amount'] = $warehouseout->discount_amount;
        $data['paid_amount'] = $warehouseout->paid_amount;
        $data['is_paid'] = $warehouseout->is_paid;
        $data['suptrans_id'] = $warehouseout->suptrans_id;
        $data['paidtrans_ids'] = $warehouseout->paidtrans_ids;
        $data['shiptrans_id'] = $warehouseout->shiptrans_id;
        $data['delivery_id'] = $warehouseout->delivery_id;
        $data['cost_extra'] = $warehouseout->cost_extra;
        $data['status'] = $warehouseout->status;

        
        $outd =  \App\Models\DOut::create($data);

        return $outd;
    }
    public  function s_update_final_amount( $new_amount,$delete = false )
    {
         $delete?$scount = 0:$scount = 1;
        \App\Models\Systrans::remove_warehouseout($this->id,$this->final_amount,1);
        \App\Models\Systrans::add_warehouseout($this->id,$new_amount,$scount);
       
    }
}
