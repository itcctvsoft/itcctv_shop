<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
class WarehouseoutDetail extends Model
{
    use HasFactory;
    protected $fillable = ['wo_id','wh_id', 'wto_id','product_id', 'quantity','price','benefit','expired_at','in_ids','prebalance','doc_type','qty_returned','is_deleted'];
    public static function c_create($product_detail,$cost_extra = 0)
    {
       
        $in_ids = json_decode($product_detail['in_ids']);
        $tong = 0;
        if ( $in_ids != null)
        {
            foreach ($in_ids as $in_id)
            {
                if($in_id->qty > 0)
                {
                    $detail_in = \App\Models\WarehouseInDetail::find($in_id->id);
                    $tong +=($product_detail['price'] -$detail_in->price - $cost_extra)  * $in_id->qty;
                    // \Log::info('$detail_in->benefit :'.$detail_in->benefit );
                    // \Log::info(" product_detail['price'] :".$product_detail['price'] );
                    $detail_in->benefit += ($product_detail['price'] - $detail_in->price - $cost_extra)*$in_id->qty;
                    // \Log::info('$detail_in->benefit :'.$detail_in->benefit );
                    $detail_in->save();
                }
                
            } 
            $product_detail['benefit'] = $tong;
        }
        else
        {
            $product_detail['benefit'] =( $product_detail['price'] - $cost_extra)  * $product_detail['quantity'];
        }
        WarehouseoutDetail::create($product_detail);
    }

    public static function r_create($product_detail,$old_detail,$detailseri,$wo_id)
    {
        \Log::info('r_create');
       
        $in_ids = json_decode($old_detail->in_ids);
        $product_detail['in_ids'] = $old_detail->in_ids;
        $moi_in_ids = [];
        $tong = 0;
        $tonggiam = 0;
        if ( $in_ids != null)
        {
            $qty_return = $product_detail['quantity'];
            foreach ($in_ids as $in_id)
            {
               
                $detail_in = \App\Models\WarehouseInDetail::find($in_id->id);
                if( $qty_return   > $in_id->qty)
                {
                    $detail_in->qty_sold -= $in_id->qty;
                    \Log::info('$old_detail->price:'.$old_detail->price);
                    \Log::info('$detail_in->price:'.$detail_in->price);
                    \Log::info('$in_id->qty:'.$in_id->qty);
                    $qty_return -= $in_id->qty  ;
                    $detail_in->benefit -= ($old_detail->price - $detail_in->price)*$in_id->qty;
                    $tong +=($old_detail->price - $detail_in->price)*$in_id->qty;
                
                    $in_id->qty = 0;
                    
                }
                else
                {
                    \Log::info('$old_detail->price:'.$old_detail->price);
                    \Log::info('$detail_in->price:'.$detail_in->price);
                    \Log::info('$qty_return:'.$qty_return);
                    $detail_in->qty_sold -= $qty_return;
                    $in_id->qty -= $qty_return;
                    $detail_in->benefit -= ($old_detail->price - $detail_in->price)* $qty_return;
                    $tong +=  ($old_detail->price - $detail_in->price)* $qty_return;
                  
                    $qty_return = 0;
                }

                $detail_in->save();

            } 
            $series =  explode(",",  $detailseri); 
            foreach ($series as $seri)
            {
                $seri = trim ($seri);
                if ($seri == '')
                    continue;
                //tim seri cũ đã xuất
                $wo_seri = \App\Models\WarehouseoutDetailSeries::where('wo_id',$old_detail->wo_id)->where('doc_type','wo')
                ->where('seri',$seri)
                ->where('product_id',$product_detail['product_id'])->first();
                if (!$wo_seri)
                {
                    return response()->json(['msg'=>'Số seri '.$seri.' không  có!','status'=>false]);
                }
                //tim seri nhap cu tao seri nhap moi thay the ma khong thay doi seri cu
                $wi_seri = \App\Models\WarehouseinDetailSeries::find($wo_seri->in_id);
                \App\Models\WarehouseinDetailSeries::c_create($wi_seri->wi_id,$wi_seri->seri, $wi_seri->product_id,'wi',$wi_seri->wh_id);
                \App\Models\WarehouseoutDetailSeries::r_create($wo_id,$wi_seri->seri, $wi_seri->product_id,'wor',$wi_seri->wh_id);
                
            }
            $old_detail->qty_returned += $product_detail['quantity'];
            $old_detail->in_ids = json_encode($in_ids );
            \Log::info('$tong:'.$tong);
            \Log::info(' $old_detail->benefit:'. $old_detail->benefit);
            $old_detail->benefit -= $tong;
            \Log::info(' $old_detail->benefit:'. $old_detail->benefit);
            $old_detail->save();
           
        }
        else
        {
            // $product_detail['benefit'] = $product_detail['price']  * $product_detail['quantity'];
        }
        $product_detail['benefit'] = $product_detail['price']  * $product_detail['quantity'] - $old_detail->price * $product_detail['quantity'] ;
     
        WarehouseoutDetail::create($product_detail);
       
    }

    public static function deleteWO($wo_details ,$doc_type) //dung cho xoa warehouseoutdetail trong w to p, w to d ...
    {
        
        foreach($wo_details as $wo_detail)
        {

            $inv = \App\Models\Inventory::where('product_id',$wo_detail->product_id)
                ->where('wh_id',$wo_detail->wh_id)
                ->first();
            if($inv)
                $data['prebalance'] =$inv->quantity;
            else
                $data['prebalance'] = 0;
            $data['doc_id']= 0;
            $data['doc_type'] =  $doc_type;
            $data['wh_id'] =   $wo_detail->wh_id;
            $data['product_id'] = $wo_detail->product_id;
            $data['quantity'] = $wo_detail->quantity;
            $data['qty_sold'] = 0;
            $data['price'] =$wo_detail->price;
            // \App\Models\WarehouseInDetail::create($data);
               //-----------------
               $data['doc_id'] =  0;
               $data['operation'] =  1;
               \App\Models\InventoryDetail::create($data);
               //---------------
            $wo_detail->delete();  
            
        }
    }
    public static function deleteDetailPro($detailpro,$extraprice,$wh_id)
    {
        $product = \App\Models\Product::where('id',$detailpro->product_id)->first();
        if($product->type=='normal')
        {
            if($product->sold ==$detailpro->quantity )
            {
                $avg = 0;
            }
            else
            {
                $avg =  $product->sold * $product->price_out - ($detailpro->price -$extraprice )*$detailpro->quantity;
                $avg = $avg/($product->sold - $detailpro->quantity);
            }
            $product->sold -= $detailpro->quantity;
            $product->stock += $detailpro->quantity;
            $product->price_out = $avg;
            
            $inventory = \App\Models\Inventory::where('product_id',$detailpro->product_id)
                ->where('wh_id',$wh_id)->first();

            $prebalance = $inventory->quantity;

            $inventory->quantity += $detailpro->quantity;
            $product->save();
            $inventory->save();
            //return product to warehouseindetail
            $in_ids = json_decode($detailpro->in_ids);
            foreach ($in_ids as $in_id)
            {
                $detail_in = \App\Models\WarehouseInDetail::find($in_id->id);
                $detail_in->qty_sold -= $in_id->qty;
                $detail_in->save();
            } 
        }
        ///
        // $data['wo_id']=  $dout_id;
        // $data['wto_id'] =  $detailpro->wto_id;
        // $data['product_id'] = $detailpro->product_id;
        // $data['quantity'] = $detailpro->quantity;
        // $data['price'] =$detailpro->price;
        // $data['expired_at'] = $detailpro->expired_at;
        // $data['in_ids'] =  $detailpro->in_ids;
        // $dout = \App\Models\DOutdetail::create($data);
       
        //tao warehouse in detail tương ứng ko có phiếu quản lý để theo dõi balance
        if(isset($inventory))
            $datai['prebalance'] = $prebalance;
        else
            $datai['prebalance'] = 0;
        $datai['doc_id']= 0;
        $datai['doc_type'] =  'wi';
        $datai['wh_id'] =  $wh_id;
        $datai['product_id'] = $detailpro->product_id;
        $datai['quantity'] = $detailpro->quantity;
        $datai['qty_sold'] = 0;
        $datai['price'] =$detailpro->price;
        \App\Models\WarehouseInDetail::create($datai);
        //cap nhat warehouse out wo_id về không để ko dc phiếu nào quản lý
        // $detailpro->delete();
        $detailpro->wo_id = 0;
        $detailpro->save();
    }

    public static function deleteDetailProVersion($detailpro,$extraprice,$wh_id,$dout_id)
    {
        $product = \App\Models\Product::where('id',$detailpro->product_id)->first();
        if($product->type=='normal')
        {
            if($product->sold ==$detailpro->quantity )
            {
                $avg = 0;
            }
            else
            {
                $avg =  $product->sold * $product->price_out - ($detailpro->price -$extraprice )*$detailpro->quantity;
                $avg = $avg/($product->sold - $detailpro->quantity);
            }
            Log::info(' $detailpro->quantity:'. $detailpro->quantity);
            Log::info('  $product->sold:'.  $product->sold);
            $product->sold -= $detailpro->quantity;
            $product->stock += $detailpro->quantity;
            $product->price_out = $avg;
            
            $inventory = \App\Models\Inventory::where('product_id',$detailpro->product_id)
                ->where('wh_id',$wh_id)->first();

            $prebalance = $inventory->quantity;

            $inventory->quantity += $detailpro->quantity;
            $product->save();
            $inventory->save();
            //return product to warehouseindetail
            $in_ids = json_decode($detailpro->in_ids);
            foreach ($in_ids as $in_id)
            {
                $detail_in = \App\Models\WarehouseInDetail::find($in_id->id);
                $detail_in->qty_sold -= $in_id->qty;
                $detail_in->benefit -= ($detailpro->price - $detail_in->price)*$in_id->qty; // xoa thi giamr lowi nhuan
                $detail_in->save();
            } 
        }
        ///
       
        $data['wo_id']=  $dout_id;
        $data['wto_id'] =  $detailpro->wto_id;
        $data['product_id'] = $detailpro->product_id;
        $data['quantity'] = $detailpro->quantity;
        $data['price'] =$detailpro->price;
        $data['expired_at'] = $detailpro->expired_at;
        $data['in_ids'] =  $detailpro->in_ids;
        $dout = \App\Models\DOutdetail::create($data);
        
        //tao warehouse in detail tương ứng ko có phiếu quản lý để theo dõi balance
        if(isset( $inventory))
            $datai['prebalance'] = $prebalance;
        else
            $datai['prebalance'] = 0;
        $datai['doc_id']= $dout_id;
        $datai['doc_type'] =  'dout';
        $datai['wh_id'] =  $wh_id;
        $datai['product_id'] = $detailpro->product_id;
        $datai['quantity'] = $detailpro->quantity;
        $datai['operation'] = 1;
        // $datai['qty_sold'] = 0;
        $datai['price'] =$detailpro->price;
        // \App\Models\WarehouseInDetail::create($datai);
        \App\Models\InventoryDetail::create($datai);
        Log::info(' $detailpro->doc_id:'. $detailpro->wo_id);
        Log::info(' $detailpro->doc_type:'. $detailpro->doc_type);
        $oldinv_detail = \App\Models\InventoryDetail::where('doc_id',$detailpro->wo_id)
            ->where('doc_type',$detailpro->doc_type)->first();
        $oldinv_detail->doc_id =   $datai['doc_id'];
        $oldinv_detail->doc_type = $datai['doc_type'];
        $oldinv_detail->save();

        //cap nhat warehouse out wo_id về không để ko dc phiếu nào quản lý
        // $detailpro->delete();
        $detailpro->is_deleted = 1; 
        $detailpro->save();
    }
    public static function deleteReturnDetailProVersion($detailpro,$extraprice,$wh_id,$dout_id )
    {

        $product = \App\Models\Product::where('id',$detailpro->product_id)->first();
        if($product->type=='normal')
        {
        //     if($product->stock ==$detailpro->quantity )
        //     {
        //         $avg = 0;
        //     }
        //     else
        //     {
        //         $avg =  $product->stock * $product->price_avg - ($extraprice + $detailpro->price)*$detailpro->quantity;
        //         $avg = $avg/($product->stock - $detailpro->quantity);
        //     }
            $product->stock += $detailpro->quantity;
            $inventory = \App\Models\Inventory::where('product_id',$detailpro->product_id)
                ->where('wh_id',$wh_id)->first();
            $prebalance = $inventory->quantity;
            $inventory->quantity -= $detailpro->quantity;
            $product->save();
            $inventory->save();

            $in_ids = json_decode($detailpro->in_ids);
            foreach ($in_ids as $in_id)
            {
                $detail_in = \App\Models\WarehouseInDetail::find($in_id->id);
                $detail_in->qty_sold += $in_id->qty;
                $detail_in->benefit += ($detailpro->price - $detail_in->price)*$in_id->qty; // xoa thi giamr lowi nhuan
                $detail_in->save();
            } 

        }
        $data['doc_id']= $dout_id;
        $data['wo_id']= $dout_id;
        $data['doc_type'] =  'dout';
        $data['wh_id'] = $detailpro->wh_id;
        $data['product_id'] = $detailpro->product_id;
       
        $data['quantity'] = $detailpro->quantity;
        $data['price'] =$detailpro->price;
        $data['expired_at'] = $detailpro->expired_at;
        
        $dout = \App\Models\DOutdetail::create($data);
        // $detailpro->delete();
        if(isset($prebalance))
             $data['prebalance'] = $prebalance;
        else
            $data['prebalance'] = 0;
      
        $data['operation'] = -1;
        // $data['price'] =$detailpro->price;
        // $data['in_ids']= $detailpro->id;
        // \App\Models\WarehouseoutDetail::create($data);
        \App\Models\InventoryDetail::create($data);
        \Log::info('$detailpro->doc_id:'.$detailpro->wo_id);
        \Log::info('$detailpro->doc_type:'.$detailpro->doc_type);
        $oldinv_detail = \App\Models\InventoryDetail::where('doc_id',$detailpro->wo_id)
            ->where('doc_type',$detailpro->doc_type)->first();
        $oldinv_detail->doc_id =   $data['doc_id'];
        $oldinv_detail->doc_type = $data['doc_type'];
        $oldinv_detail->save();
        //cap nhat widetail ve 0 giong nhu xoa
        // $detailpro->doc_id = 0;
        $detailpro->is_deleted = 1; 
        $detailpro->save();


    }
    public static function returnDetailPro($detailpro,$extraprice,$wh_id,$dout_id )
    {
        // $product = \App\Models\Product::where('id',$detailpro->product_id)->first();
       
        // if($product->type=='normal')
        // {
       
        //     if($product->sold ==$detailpro->quantity )
        //     {
        //         $avg = 0;
        //     }
        //     else
        //     {
        //         $avg =  $product->sold * $product->price_out - ($detailpro->price -$extraprice )*$detailpro->quantity;
        //         $avg = $avg/($product->sold - $detailpro->quantity);
        //     }
        //     $product->sold -= $detailpro->quantity;
        //     $product->stock += $detailpro->quantity;
        //     $product->price_out = $avg;
            
        //     $inventory = \App\Models\Inventory::where('product_id',$detailpro->product_id)
        //         ->where('wh_id',$wh_id)->first();

        //     $prebalance = $inventory->quantity;

        //     $inventory->quantity += $detailpro->quantity;
        //     $product->save();
        //     $inventory->save();
        //     //return product to warehouseindetail
        //     $in_ids = json_decode($detailpro->in_ids);
        //     foreach ($in_ids as $in_id)
        //     {
        //         $detail_in = \App\Models\WarehouseInDetail::find($in_id->id);
        //         $detail_in->qty_sold -= $in_id->qty;
        //         $detail_in->save();
        //     } 
        // }
        // ///
        // $data['wo_id']=  $dout_id;
        // $data['wto_id'] =  $detailpro->wto_id;
        // $data['product_id'] = $detailpro->product_id;
        // $data['quantity'] = $detailpro->quantity;
        // $data['price'] =$detailpro->price;
        // $data['expired_at'] = $detailpro->expired_at;
        // $data['in_ids'] =  $detailpro->in_ids;
        // $dout = \App\Models\DOutdetail::create($data);
        // //tao warehouse in detail tương ứng ko có phiếu quản lý để theo dõi balance
        // if( isset($inventory))
        //     $datai['prebalance'] = $prebalance;
        // else
        //     $datai['prebalance'] = 0;
        // $datai['doc_id']= 0;
        // $datai['doc_type'] =  'wi';
        // $datai['wh_id'] =  $wh_id;
        // $datai['product_id'] = $detailpro->product_id;
        // $datai['quantity'] = $detailpro->quantity;
        // $datai['qty_sold'] = 0;
        // $datai['price'] =$detailpro->price;
        // \App\Models\WarehouseoutDetail::create($datai);
        // //cap nhat warehouse out wo_id về không để ko dc phiếu nào quản lý
        // // $detailpro->delete();
        // $detailpro->wo_id = 0;
        // $detailpro->save();
    }
}
