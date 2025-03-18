<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WarehouseIn extends Model
{
    use HasFactory;
    protected $fillable = ['code','version','wh_id', 'supplier_id', 'vendor_id','final_amount','discount_amount','paid_amount','is_paid','suptrans_id','paidtrans_id',
    'shiptrans_id','cost_extra','debtbefore','debtafter','bankpayment','status','returned_ids'];
    public static function c_create($data)
    {
        $mw = WarehouseIn::create($data);
        $mw->code = "WIN" . sprintf('%09d',$mw->id);
        $mw->save();
        \App\Models\Systrans::add_warehousein($mw->id,$mw->final_amount,1);
        return $mw;
    }
    public  function s_update_final_amount( $new_amount,$delete = false )
    {
         $delete?$scount = 0:$scount = 1;
        \App\Models\Systrans::remove_warehousein($this->id,$this->final_amount,1);
        \App\Models\Systrans::add_warehousein($this->id,$new_amount,$scount);
       
    }
    public static function log_change($warehousein)
    {
          
        $data['inid'] = $warehousein->id;
        $data['code'] = $warehousein->code;
        $data['version'] = $warehousein->version;
        $data['wh_id'] = $warehousein->wh_id;
        $data['supplier_id'] = $warehousein->supplier_id;
        $data['vendor_id'] = $warehousein->vendor_id;
        $data['final_amount'] = $warehousein->final_amount;
        $data['discount_amount'] = $warehousein->discount_amount;
        $data['paid_amount'] = $warehousein->paid_amount;
        $data['is_paid'] = $warehousein->is_paid;
        $data['suptrans_id'] = $warehousein->suptrans_id;
        $data['paidtrans_ids'] = $warehousein->paidtrans_ids;
        $data['shiptrans_id'] = $warehousein->shiptrans_id;
        $data['status'] = $warehousein->status;
        $data['cost_extra'] = $warehousein->cost_extra;
        $outd =  \App\Models\DIn::create($data);

        return $outd;
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'supplier_id');
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
        $doc_type = 'wi';
        if($this->status == 'returned')
            $doc_type = 'wir';
        
        $subquery = \App\Models\Product::select('id','title');
        $details = \App\Models\WarehouseInDetail::where('doc_id', $this->id)
            ->where('doc_type', $doc_type)
            ->where('is_deleted', 0)
            ->joinSub($subquery, 'products', function ($join) {
                $join->on('warehouse_in_details.product_id', '=', 'products.id');
            })
            ->select(
                'warehouse_in_details.*', 
                'products.title', 
              
            )
            ->get();
        foreach ($details as $wi )
        {
            $series = "";
            $i = 0;
            $wo_seris = \DB::select("select seri from warehousein_detail_series where (doc_type='wi'or doc_type='wir') and wi_id =".$wi->doc_id ." and product_id = ".$wi->product_id );
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
    public function updateFinalAmount()
    {
        $details = \App\Models\WarehouseInDetail::where('doc_id',$this->id)->where('doc_type','wi')
                ->where('is_deleted',0)->get();
        $total = 0;
        foreach($details as $detail)
        {
            $total += $detail->price * ($detail->qty - $detail->qty_returned);
        }
        $this->final_amount = $total;
        $this->save();
    }
}
