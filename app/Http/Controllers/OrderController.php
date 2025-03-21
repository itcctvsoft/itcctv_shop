<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Inventory;
use App\Models\Product;
use App\Models\Warehouse;
use App\Models\Order;
use App\Models\SupTransaction; 
use App\Models\OrderDetail;
use App\Models\Bankaccount;
use App\Models\BankTransaction;
use App\Models\FreeTransaction;
use App\Models\UGroup;
use App\Models\Warehouseout;
use App\Models\User;
use App\Models\WarehouseoutDetail;
use App\Models\InventoryDetail;
class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    protected $pagesize;
    public function __construct( )
    {
        $this->pagesize = env('NUMBER_PER_PAGE','20');
        $this->middleware('auth');
    }
    public function orderThanhtoan(Request $request)
    {
        $id =  $request->id;
        $paymentController = new \App\Http\Controllers\Frontend\PaymentController();
        $paymentController->paymentorder_se_id($id);
        return redirect()->route('order.index')->with('success','Thanh toán thành công!'); 

    }
    public function index()
    {
        $func = "order_list";
        if(!$this->check_function($func))
        {
            return redirect()->route('unauthorized');
        }
        //
        $active_menu="or_list";
        $breadcrumb = '
        <li class="breadcrumb-item"><a href="#">/</a></li>
        <li class="breadcrumb-item active" aria-current="page"> Danh sách đặt hàng </li>';
        $orders=Order::orderBy('id','DESC')->paginate($this->pagesize);
        return view('backend.orders.index',compact('orders','breadcrumb','active_menu'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $func = "order_add";
        if(!$this->check_function($func))
        {
            return redirect()->route('unauthorized');
        }
        $active_menu="or_list";
        $breadcrumb = '
        <li class="breadcrumb-item"><a href="#">/</a></li>
        <li class="breadcrumb-item  " aria-current="page"><a href="'.route('user.index').'">Ds đặt hàng</a></li>
        <li class="breadcrumb-item active" aria-current="page"> thêm mới </li>';
        $warehouses = Warehouse::where('status','active')->orderBy('id','ASC')->get();
        $user = auth()->user();
        return view('backend.orders.create',compact('breadcrumb','active_menu', 'warehouses', 'user' ));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $func = "order_add";
        if(!$this->check_function($func))
        {
            return redirect()->route('unauthorized');
        }
        //
        $data = $request->importDoc;
        // return $data;
        
       
        $user = auth()->user();
        $data['vendor_id'] = $user->id;
        
        ///save product detail ////////////
        ////average price///////////////////
        $details = $request->products;
        $count_item = 0;
        foreach ($details as $detail)
        {
            $count_item += $detail['quantity'];
        }
        $cost_extra = ($data['discount_amount'])/ $count_item ;
        $data['cost_extra'] = $cost_extra ;
        $wo = order::create($data);
        // return $wi;
        ////////////////////////////////////
        foreach ($details as $detail)
        {
            $product_detail['wo_id'] = $wo->id;
            $product_detail['product_id']= $detail['id'];
            $product_detail['quantity'] = $detail['quantity'];
            $product_detail['price'] = $detail['price'];
            $product = Product::find($detail['id']);
            $start_date = date('Y-m-d H:i:s');
            if($product->expired)
            {
                $strday = '+' . $product->expired*30 .' days';
                $end_date = date("Y-m-d 23:59:59", strtotime( $strday, strtotime($start_date)));
                $product_detail['expired_at'] = $end_date;
            }
            
            OrderDetail::create($product_detail);
            //decrease stock
             
        }
        ///create SupTransaction
        
       ///create ship invocie ///////////
        
       ///create log /////////////
       
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $func = "order_list";
        if(!$this->check_function($func))
        {
            return redirect()->route('unauthorized');
        }
        //
        $order = order::find($id);
        if($order)
        {
            $active_menu="or_list";
            $breadcrumb = '
            <li class="breadcrumb-item"><a href="#">/</a></li>
            <li class="breadcrumb-item  " aria-current="page"><a href="'.route('order.index').'">DS đặt hàng</a></li>
            <li class="breadcrumb-item active" aria-current="page"> Xem chi tiết</li>';
            $wo_details = OrderDetail::where('wo_id',$id)->get();
            return view('backend.orders.show',compact('breadcrumb','order','active_menu','wo_details'));
        }
        else
        {
            return back()->with('error','Không tìm thấy dữ liệu');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $func = "order_edit";
        if(!$this->check_function($func))
        {
            return redirect()->route('unauthorized');
        }
        //
        $order = order::find($id);
        if($order)
        {
            $active_menu="wo_list";
            $breadcrumb = '
            <li class="breadcrumb-item"><a href="#">/</a></li>
            <li class="breadcrumb-item  " aria-current="page"><a href="'.route('order.index').'">Danh sách đặt hàng</a></li>
            <li class="breadcrumb-item active" aria-current="page"> điều chỉnh phiếu đặt hàng </li>';
            $warehouses = Warehouse::where('status','active')->orderBy('id','ASC')->get();
             
            
            $user = auth()->user();
            
            return view('backend.orders.edit',compact('breadcrumb','order','active_menu','warehouses', 'user' ));
        }
        else
        {
            return back()->with('error','Không tìm thấy dữ liệu');
        }
    }
    public function getProductList(Request $request)
    {
        $this->validate($request,[
            'wo_id'=>'numeric|required',
        ]);
        $wo = Order::find($request->wo_id);
        $query = "(select id,photo, type,title from products ) as p";
        $query1 = "(select product_id ,quantity from inventories where wh_id = ".$wo->wh_id.") as np";
               
        $products = DB::table('order_details')
        ->select ('order_details.price','order_details.product_id','order_details.quantity', 'p.title','p.photo','p.id','p.type','np.quantity as stock_qty')
        ->where('wo_id',$request->wo_id)
        ->leftJoin(\DB::raw($query),'order_details.product_id','=','p.id')
        ->leftJoin(\DB::raw($query1),'order_details.product_id','=','np.product_id')
        ->orderBy('id','ASC')->get();
        foreach($products as $product)
        {
            $query = "select b.*,c.id as idg, c.title from (select id, price, ugroup_id from group_prices where product_id = ".$product->id
            ." ) as b left join (select id,title from u_groups) as c on b.ugroup_id = c.id  order by c.id ASC";
            $prices = DB::select($query) ;
      
            $product->groupprice=$prices;
        }
        return response()->json(['msg'=>$products,'status'=>true]);

    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $func = "order_edit";
        if(!$this->check_function($func))
        {
            return redirect()->route('unauthorized');
        }
        //
          // return $request->all();
          $data = $request->importDoc;
          $oldorder = order::find($id);
          // return $oldorder;
          if($data['id']==null || $data['id']==0 || $oldorder==null)
              return response()->json(['msg'=>'không tìm thấy!','status'=>false]);
         
          
         
          $user = auth()->user();
          $data['vendor_id'] = $user->id;
          //check detail product are exported
          $detailpros = orderDetail::where('wo_id',$data['id'])->get();
          
          
          //delete all old product detail
          
          foreach($detailpros as $dtpro)
          {
            $dtpro->delete();
          }
          ///delete sup trans 1 for importing
         
          
           ///save product detail ////////////
          ////average price///////////////////
          $details = $request->products;
          $count_item = 0;
          foreach ($details as $detail)
          {
              $count_item += $detail['quantity'];
          }
          $cost_extra = ($data['discount_amount'])/ $count_item ;
          $data['cost_extra'] = $cost_extra ;
          $oldorder->fill($data)->save();
  
          // return $wi;
          ////////////////////////////////////
          foreach ($details as $detail)
          {
              $product_detail['wo_id'] = $oldorder->id;
              $product_detail['product_id']= $detail['id'];
              $product_detail['quantity'] = $detail['quantity'];
              $product_detail['price'] = $detail['price'];
              $product = Product::find($detail['id']);
              $start_date = date('Y-m-d H:i:s');
              if($product->expired)
              {
                  $strday = '+' . $product->expired*30 .' days';
                  $end_date = date("Y-m-d 23:59:59", strtotime( $strday, strtotime($start_date)));
                  $product_detail['expired_at'] = $end_date;
              }
             
              
              orderDetail::create($product_detail);
              //decrease stock
               
          }
          
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $func = "order_delete";
        if(!$this->check_function($func))
        {
            return redirect()->route('unauthorized');
        }
        //
        $oldorder = Order::find($id);
        if(  $oldorder==null)
            return response()->json(['msg'=>'không tìm thấy!','status'=>false]);
        $user = auth()->user();
        //check detail product are exported
        $detailpros = orderDetail::where('wo_id',$oldorder->id)->get();
        
        //delete all old product detail
        
        foreach($detailpros as $dtpro)
        {
          $dtpro->delete();
        }
        $oldorder->delete();
        ///delete sup trans 1 for importing
       return redirect()->route('order.index')->with('success','Xóa thành công!'); 
    }
    public function orderOutUpdate(Request $request)
    {
        $data = $request->importDoc;
        // return $data;
        if($data['paid_amount'] == $data['final_amount'])
            $data['is_paid'] = 1;
        else
            $data['is_paid'] = 0;
       
        $user = auth()->user();
        $data['vendor_id'] = $user->id;
        $order = Order::find($data['id']);
        $data['id'] = 0;
        if($order == null)
        {
            return response()->json(['msg'=>'không tìm thấy!','status'=>false]);
        }
        

        $func = "warout_add";
        if(!$this->check_function($func))
        {
            return redirect()->route('unauthorized');
        }
        $data = $request->importDoc;
        // return $data;
        $customer = \App\Models\User::find($data['customer_id']);
        $deb_before = $customer->budget;

        $totalbankpaid = $data['paid_amount'];
        $totalbudgetpaid = 0;
        if($customer->budget > 0 && $data['paid_amount'] < $data['final_amount'])
        {
            if($customer->budget + $data['paid_amount']  >= $data['final_amount'])
            {
                $totalbudgetpaid = ( $data['final_amount'] - $data['paid_amount'] );
                $data['paid_amount']  =  $data['final_amount'];
                 
            }
            else
            {
                $data['paid_amount']  =  $data['paid_amount'] +  $customer->budget;
                $totalbudgetpaid  =  $customer->budget;
            }
        }
       
        if($data['paid_amount'] == $data['final_amount'])
            $data['is_paid'] = 1;
        else
            $data['is_paid'] = 0;
       
        $user = auth()->user();
        $data['vendor_id'] = $user->id;
        if ($data['discount_amount'] == null)
            $data['discount_amount']=0;
        if ($data['shipcost'] == null)
            $data['shipcost']=0;
        ///check product inventory//////
        $details = $request->products;
        foreach ($details as $detail)
        {
            
            $pro_inventory = Inventory::where('product_id',$detail['id'])->where('wh_id', $data['wh_id'])->first();
            if(!$pro_inventory || $pro_inventory->quantity < $detail['quantity'] )
            {
                // return 1;
                return response()->json(['msg'=>'Số lượng trong kho không đủ','status'=>false]);
            }
              ////update series for each product
              $series =  explode(",",  $detail['seri']);
              $count_n =0;
              if($detail['seri']!= '')
              {
                  $count_n =count($series );
              }
            
              
              $counts_n = \DB::select("select count(id) as tong from warehousein_detail_series where product_id = ".$detail['id'].' and is_sold = 0');

              $counts_n = $counts_n[0]->tong;
              if($count_n > $counts_n )
              {
                    // return 2;
                    return response()->json(['msg'=>'Số lượng seri trong đơn lớn hơn trong kho!','status'=>false]);
              }
              if($count_n > $detail['quantity'] )
              {
                    // return 3;
                    return response()->json(['msg'=>'số seri lớn hơn số trong kho','status'=>false]);
              }
              if($count_n > 0)
              {
                    foreach ($series as $seri)
                    {
                        $seri = trim($seri);
                        if ($seri == '')
                        continue;
                        $query ='select * from warehousein_detail_series where seri ="'.$seri.'" and is_sold = 0 and product_id ='.$detail['id'];
                        $rows = \DB::select($query);
                        if(count($rows) == 0)
                        {
                            // return 5;
                            return response()->json(['msg'=>'Số sp không seri lớn hơn số sp không seri trong kho','status'=>false]);
                        }
                            
                    } 
              }
             
              //so hang khong co seri ton kho
              $n_noseri = $pro_inventory->quantity - $counts_n ;
              //so hang khong co seri xuat kho
              $sold_noseri =$detail['quantity'] - $count_n;
              if($sold_noseri > $n_noseri) //neu so hang ban ko seri > so hàng tonkho thi false
              {
                    // return 4;
                    return response()->json(['msg'=>'Seri không có trong kho','status'=>false]);
              }

        }
        ///save product detail ////////////
        ////average price///////////////////
        \DB::beginTransaction();
        try {
                $count_item = 0;
                foreach ($details as $detail)
                {
                    $count_item += $detail['quantity'];
                }
                $cost_extra = ($data['discount_amount'])/ $count_item ;
                $data['cost_extra'] = $cost_extra ;
                $data['bankpayment'] = $totalbankpaid;
                $data['debtbefore'] = $deb_before;
                $data['debtafter'] =  $deb_before - $data['final_amount'];

                $wo = Warehouseout::c_create($data);
            
                // return $wi;
                // dd($wo);
                ////////////////////////////////////
                foreach ($details as $detail)
                {
                    $product_detail['wo_id'] = $wo->id;
                    $product_detail['wh_id'] = $data['wh_id'];
                    $product_detail['product_id']= $detail['id'];
                    $product_detail['quantity'] = $detail['quantity'];
                    $product_detail['price'] = $detail['price'];
                    $product_detail['operation'] = -1;
                    $product_detail['doc_id'] = $wo->id;
                    //tim pre balance
                    $inv = \App\Models\Inventory::where('product_id',$detail['id'])
                        ->where('wh_id',$data['wh_id'])
                        ->first();
                    if( $inv)
                        $product_detail['prebalance'] =$inv->quantity;
                    else
                        $product_detail['prebalance'] = 0;
                    //save expired days
                    $product = Product::find($detail['id']);
                    $start_date = date('Y-m-d H:i:s');
                    if($product->expired)
                    {
                        $strday = '+' . $product->expired*30 .' days';
                        $end_date = date("Y-m-d 23:59:59", strtotime( $strday, strtotime($start_date)));
                        $product_detail['expired_at'] = $end_date;
                    }
                    $in_ids=array();

                    // return ($in_ids);
                    //decrease stock
                    ////update series for each product
                    $series =  explode(",",  $detail['seri']);
                    $count_n =0;
                    if($detail['seri']!= '')
                    {
                        $count_n =count($series );
                    }
                    $counts_n = \DB::select ("select count(id) as tong from warehousein_detail_series where product_id = ".$detail['id'].' and is_sold = 0'); 
                    $counts_n = $counts_n[0]->tong;
                    //so hang khong co seri xuat kho
                    $sold_noseri =$detail['quantity'] - $count_n;
                    Inventory::subProductInv($product_detail['product_id'], $data['wh_id'], $detail['quantity'], $product_detail['price'], $cost_extra);
                    $in_ids = Inventory::updateWarehouseLastIn($product_detail['product_id'], $data['wh_id'],$sold_noseri);
                    
                    foreach ($series as $seri)
                    {
                        $seri = trim ($seri);
                        if ($seri == '')
                            continue;
                        $wi_seri = \App\Models\WarehouseinDetailSeries::where('seri',$seri)
                            ->where('product_id',$detail['id'])->where('is_sold',0)->first();
                        $wi_seri->is_sold = 1;
                        $wi_seri->save();
                        $data_seri['wo_id'] = $wo->id;
                        $data_seri['seri'] = $seri;
                        $data_seri['product_id'] = $detail['id'];
                        $data_seri['in_id'] = $wi_seri->id;
                        $data_seri['doc_type'] = 'wo';
                        \App\Models\WarehouseoutDetailSeries::create($data_seri);
                        $detail_in = \App\Models\WarehouseInDetail::where('doc_id',$wi_seri->wi_id)
                        ->where('is_deleted',0)
                            ->where('product_id',$wi_seri->product_id)->first();
                        $in_id = Inventory::updateWarehouseInDetails($product_detail['product_id'], $data['wh_id'],$detail_in);
                        array_push($in_ids, $in_id);
                    }
                    $product_detail['in_ids'] = json_encode($in_ids);
                    $product_detail['doc_type']='wo'; //loai xuat la phieu xuat ban hang
                    WarehouseoutDetail::c_create($product_detail,$cost_extra);
                    InventoryDetail::create($product_detail);

                
                }
            
                ///create SupTransaction
                $sps = SupTransaction::createSubTrans($wo->id,'wo',-1,$data['final_amount'], $data['customer_id']);
             
                $wo->suptrans_id = $sps->id;
                ///create paid transaction
                if( $totalbankpaid > 0)
                {
                    $bank_doc = BankTransaction::insertBankTrans($user->id,$data['bank_id'],1,$wo->id,'wo',$totalbankpaid );
                    SupTransaction::createSubTrans($bank_doc->id,'fi',1, $totalbankpaid , $data['customer_id']); 
                    $in_ids=array();
                    $in_id = new \App\Models\Number();
                    $in_id->id = $bank_doc->id;
                    array_push($in_ids,$in_id);
                    $wo->paidtrans_ids = json_encode($in_ids);
        
                }
            ///create ship invocie ///////////
            if($data['shipcost'] > 0)
            {
                    $fts= FreeTransaction::addFreeTrans($data['shipcost'],$data['bank_id'],-1,'ship',$user->id);
                    $wo->shiptrans_id = $fts->id;
                    BankTransaction::insertBankTrans($user->id,$data['bank_id'],-1,$fts->id,'fi',$data['shipcost']);
            }
            //luu uiid cho phieu xuat
            $detail = \App\Models\SettingDetail::find(1);
            if($detail->itcctv_email != '')
            {
                    $md5string = md5($detail->itcctv_email . '_'.$wo->id);
                    $wo->uiid   = $formattedString = implode('-', str_split($md5string, 4));;
            }
            
            $wo->save();
            
            $content = 'thêm đơn bán hàng' ;
            \App\Models\Log::insertLogNew($content,$wo->id,'wo',$user->id);
            // return $wo;
            $woController = new \App\Http\Controllers\WarehouseoutController();
            $html = $woController->print_invoice($wo->id);
            DB::commit();

        
            $order->status= "done";
            $order->save();
            $content = 'Thêm đơn bán hàng từ đơn đặt hàng: '.$data['wh_id'].' total: '.$data['final_amount'];
            \App\Models\Log::insertLog($content,$user->id);
            return response()->json(['msg'=>'Thêm đơn hàng thành công!','status'=>true]);
        }
        catch (\Exception $e) {
            \DB::rollback(); // Quay lại trạng thái trước đó nếu có lỗi
            \Log::error('Lỗi khi lưu đơn xuất kho: ' . $e->getMessage());
            return response()->json(['msg'=>$e->getMessage(),'status'=>false]);
            // return response()->json(['status'=>false,'msg' => 'Có lỗi xảy ra khi lưu đơn xuất kho.'], 500);
        }
       
       ///create log /////////////
      
      
    }
    public function orderOut($id)
    {
        $func = "order_list";
        if(!$this->check_function($func))
        {
            return redirect()->route('unauthorized');
        }
        $order = order::find($id);
        if($order)
        {
            $active_menu="wo_list";
            $breadcrumb = '
            <li class="breadcrumb-item"><a href="#">/</a></li>
            <li class="breadcrumb-item  " aria-current="page"><a href="'.route('order.index').'">Danh sách đặt hàng</a></li>
            <li class="breadcrumb-item active" aria-current="page"> lập phiếu bán hàng </li>';
            $warehouses = Warehouse::where('status','active')->orderBy('id','ASC')->get();
            $bankaccounts = Bankaccount::where('status','active')->orderBy('id','ASC')->get();
            $deliveries= User::where('role','delivery')->where('status','active')->orderBy('id','ASC')->get();
            // $ugroups=UGroup::where('status','active')->orderBy('id','ASC')->get();
            $user = auth()->user();
            return view('backend.orders.orderout',compact('breadcrumb','active_menu', 'warehouses','bankaccounts','user','deliveries','order'));
    
        }
        else
        {
            return back()->with('error','Không tìm thấy dữ liệu');
        }
    }
}
