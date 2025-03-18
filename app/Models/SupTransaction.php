<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupTransaction extends Model
{
    use HasFactory;
    protected $fillable = ['supplier_id','doc_id','doc_type',  'operation','amount','total','content','is_delete'];
    public static function c_create($data)
    {
        $mw = SupTransaction::create($data);
        $mw->code = "STN" . sprintf('%09d',$mw->id);
        $mw->save();
        
        return $mw;
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'supplier_id');
    } 
    public function details()
    {
        return null;
    }
    public function document()
    {
        if($this->doc_type == 'wi' || $this->doc_type == 'wir')
        {
            $wi = \App\Models\WarehouseIn::find($this->doc_id);
            return $wi;
        }
        if($this->doc_type == 'wo' || $this->doc_type == 'wor')
        {
            $wo = \App\Models\Warehouseout::find($this->doc_id);
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
        if($this->doc_type == 'fi')
        {
            $wo = \App\Models\SupTransaction::find($this->id);
            return $wo;
        }
        if($this->doc_type == 'mb' && $sp->operation == 1)
        {
            $wo = \App\Models\MaintainBack::find($this->doc_id);
            return $wo;
        }
        if($this->doc_type == 'mb' && $sp->operation == -1)
        {
            $wo = \App\Models\maintainin::find($this->doc_id);
            return $wo;
        }
        return null;
    }
    // if($sp->doc_type == 'fi')
    // {
    //     $str_route = route('suptransaction.show',$sp->id);
    //     $loai = 'Phiếu giao dịch';
      
    // }
    // if($sp->doc_type == 'fo' )
    // {
    //     $loai = "Phiếu giao dịch hủy/trả xuất hàng";
    //     if($sp->operation > 0)
    //       $ptotal = Number_format($sp->amount,0,'.',',');
    //     else
    //       $stotal = Number_format($sp->amount,0,'.',',');
    // }
    // if($sp->doc_type == 'mb' )
    // {
    //     if($sp->operation == 1)
    //     {
    //         $loai = 'phiếu trả bảo hành';
    //         $str_route = route('maintainback.show',$sp->doc_id);
    //     }
    //     else
    //     {
    //         $loai = 'phiếu nhận bảo hành ';
    //         $tt = \App\Models\MaintenanceIn::find($sp->doc_id) ;
    //         $str_route = route('maintainin.show',$sp->doc_id);
    //     }
    //     $tt = \App\Models\MaintainBack::find($sp->doc_id) ;
    //     $doc_notpaid = Number_format($tt->final_amount - $tt->paid_amount,0,'.',',') ;
    // }
    public static function createSubTransContent($doc_id,$doc_type,$operation,$amount, $supplier_id,$content)
    {
         ///create SupTransaction
         $supplier = \App\Models\User::where('id',$supplier_id)->first();
         $sptran['doc_id'] = $doc_id;
         $sptran['doc_type'] = $doc_type;
         $sptran['operation']= $operation;
         $sptran['amount']= $amount;
         $sptran['total']= $supplier->budget + $sptran['operation']* $sptran['amount'];
         $sptran['supplier_id']=$supplier_id;
         $sptran['content']=$content;
         $sps = SupTransaction::c_create($sptran);
        //  $supplier->budget = $sptran['total'];
        //  $supplier->save();
         $supplier->update_budget( $sptran['operation'],$sptran['amount'], $sps->id,'st');
        
    
         return $sps;
    }
    public static function updatePaidAmount($operation,$amount, $supplier_id)
    {
        if($amount <= 0)
            return;
        if($operation < 0)
        {
            //list all wi not paid order by time
            $warehouseins = \App\Models\WarehouseIn::where('supplier_id',$supplier_id)->where('status','active')
            ->where('is_paid',false)->orderBy('id','ASC')->get();
            
            $paid_amount = $amount;
            foreach($warehouseins as $warehousein)
            {
                echo $warehousein->final_amount .'-'. $warehousein->paid_amount.': '.($warehousein->final_amount - $warehousein->paid_amount); 
                echo '<br/>$paid_amount: '.($paid_amount); 
                if($paid_amount >= ($warehousein->final_amount - $warehousein->paid_amount))
                {
                    $paid_amount -= ($warehousein->final_amount - $warehousein->paid_amount);
                    $warehousein->paid_amount = $warehousein->final_amount;
                    $warehousein->is_paid = true;
                    $warehousein->save();
                //   echo 'whpaid_amount :'.$warehousein->paid_amount;
                //   echo '<br/>paid_amount :'.$paid_amount ;
                    
                }
                else
                {
                    $warehousein->paid_amount+= $paid_amount;
                    $warehousein->save();

                    $paid_amount = 0;
                //   echo 'whpaid_amount :'.$warehousein->paid_amount;
                //   echo '<br/>paid_amount :'.$paid_amount ;
                }
            
                if($paid_amount == 0)
                    break;
            }
        }
        else
        {
            //cap nhat cac don xuat
            $warehouseouts = \App\Models\Warehouseout::where('customer_id',$supplier_id)->where('status','active')
            ->where('is_paid',false)->orderBy('id','ASC')->get();
            $paid_amount = $amount;
            foreach($warehouseouts as $warehouseout)
            {
                if($paid_amount >= ($warehouseout->final_amount - $warehouseout->paid_amount))
                {
                    $paid_amount -= ($warehouseout->final_amount - $warehouseout->paid_amount);
                    $warehouseout->paid_amount = $warehouseout->final_amount;
                    $warehouseout->is_paid = true;
                    $warehouseout->save();
                    
                }
                else
                {
                    $warehouseout->paid_amount+= $paid_amount;
                    $warehouseout->save();
                    $paid_amount = 0;
                }
                if($paid_amount == 0)
                    break;
            }
        }
        
    }
    public static function createSubTrans($doc_id,$doc_type,$operation,$amount, $supplier_id)
    {
         ///create SupTransaction
         $supplier = \App\Models\User::where('id',$supplier_id)->first();
         $sptran['doc_id'] = $doc_id;
         $sptran['doc_type'] = $doc_type;
         $sptran['operation']= $operation;
         $sptran['amount']= $amount;
         $sptran['total']= $supplier->budget + $sptran['operation']* $sptran['amount'];
         $sptran['supplier_id']=$supplier_id;
         $sps = SupTransaction::c_create($sptran);
        //  $supplier->budget =$sptran['total'];
        //  $supplier->save();
         $supplier->update_budget( $sptran['operation'],$sptran['amount'], $sps->id,'st');
         return $sps;
    }
    public static function removeSubTrans($suptrans_id ,$mode='fo',$doc_id=0)
    {
         ///create SupTransaction
        $suptrans = SupTransaction::find($suptrans_id);
        if($suptrans)
        {
            $suptrans->is_delete = 1;
            $suptrans->save();
            $sub = SupTransaction::createSubTrans($doc_id,$mode,-1* $suptrans->operation,$suptrans->amount, $suptrans->supplier_id);
            $sub->is_delete = 1;
            $sub->save();
        }
        return true;
    }
}
