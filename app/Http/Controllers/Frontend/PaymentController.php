<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Support\Facades\DB;
use App\Models\OrderTrans;

class PaymentController extends Controller
{
    public function paymentKiemtradon(Request $request)
    {
        $order  = OrderTrans::where('code',$request->code)->first();
        if($order)
            return response()->json(['payment_status' => $order->status ] );
        else
            return response()->json(['payment_status' => 'invalid' ] );
    }
    public function paymentorder_se(Request $request)
    {
        \DB::beginTransaction();
        $data['gateway'] = $request->gateway;
        $data['transaction_date'] = $request->transactionDate;
        $data['account_number'] = $request->accountNumber;
        $data['sub_account'] = $request->subAccount;
       
        $data['transfer_type'] = $request->transferType;
        $data['transfer_amount'] = $request->transferAmount;
        $data['accumulated'] = $request->accumulated;
        
        $data['code'] = $request->code;
        $result = '';
        if (preg_match('/MEM[0-9]+/', $request->content, $matches)) {
            $result = $matches[0]; // Phần tách ra là ;MEM000000016
             // Kết quả: ;MEM000000016
             echo $result;
             $data['transaction_content'] =  $result;


             $data['reference_number'] = $request->referenceCode;
            
             $data['body'] = $request->description;
             $amount_in = 0;
             $amount_out = 0;
           
             // Kiem tra giao dich tien vao hay tien ra
     
             // echo $data['code'];
             if($request->transferType == "in")
                 $amount_in = $request->transferAmount;
             else if($request->transferType == "out")
                 $amount_out = $request->transferAmount;
             $data['amount_in'] = $amount_in;
             // echo $data['amount_in'];
             $data['amount_out'] = $amount_out;
             // echo $data['transfer_type'];
             // echo $request->transferAmount;
             PaymentTrans::create($data);
             $order_trans = OrderTrans::where('code', $data['transaction_content'])->first();
            
             if($order_trans && $order_trans->price == $data['amount_in'])
             {
                 // echo  $order->price;
                 $order_trans->status = 'Paid';
                 $order_trans->save();
                 if($order_trans->item_code=='product')
                 {
                    
                    $order = \App\Models\Order::find($order_trans->order_id);
                    if ($order) {
                        $order->status = 'Paid';
                        $order->save();
                        //tang tien quy cho khach hang
                        $userController = new \App\Http\Controllers\UserController();
                        $user_id = $order->customer_id;
                        $userController->moneyUserpaymentOnline($user_id, $amount, 2);
                    }
                      
                 }
             }
             //cap nhat các goi cũ
             MemberUser::where('end_date', '<', now())
               ->update(['status' => 'expired']);
            \DB::commit();
            return response()->json(['success' => 'true 1' ] );
        }
         
    }    
    public function paymentorder_se_id($order_id)
    {
        \DB::beginTransaction();
        $order = \App\Models\Order::find($order_id);
        if ($order) {
            $order->status = 'Paid';
            $order->save();
            //tang tien quy cho khach hang
            $userController = new \App\Http\Controllers\UserController();
            $user_id = $order->customer_id;
            $userController->moneyUserpaymentOnline($user_id, $order->final_amount, 2);
        }
        \DB::commit();
    }    
    public function showOnlinePayment(Request $request)
    {
        // dd($this->front_view);
        $amount = $request->input('amount', 0); // Tổng số tiền
        $orderDescription = $request->input('order_desc', 'Không có mô tả'); // Mô tả đơn hàng
        // $orderId = uniqid(); // Tạo mã đơn hàng
        $order_id = $request->order_id;
        // $orderTrans = \App\Models\OrderTrans::create([
        //     'code' => 'MEM' . str_pad($order_id, 9, '0', STR_PAD_LEFT),
        //     'item_code' => 'product',
        //     'order_id' => $order_id,
        //     'price' => $amount,
        //     'status' => 'UnPaid',
        //     'created_at' => now(),
        //     'updated_at' => now(),
        // ]);

        $data['detail'] = \App\Models\SettingDetail::find(1);  
        $data['categories'] = \App\Models\Category::where('status','active')->where('parent_id',null)->get();
        ///breadcrumb info
        $data['pagetitle']="Thanh toán đơn hàng" ;
        ///
        $data['links']= array();
        $link = new \App\Models\Links();
        $link->title='Kết quả tìm kiếm';
        $link->url='#';
        array_push($data['links'],$link);
        

        // return view($this->front_view.'.cart.online_payment', [
        //     'totalAmount' => $amount,
        //     'orderDescription' => $orderDescription,
        //     'orderId' => $orderTrans->code,


        // ]);

        $order = OrderTrans::where('order_id',$order_id)->where('item_code','product')->first();
        if(!$order)
        {
            
            $order = OrderTrans::create([
                'code' => 'MEM' . str_pad($order_id, 9, '0', STR_PAD_LEFT),
                'item_code' => 'product',
                'order_id' => $order_id,
                'price' => $amount,
                'status' => 'Unpaid',
            ]);
        }
        // dd($order,$order->status !== 'UnPaid');
        if($order->status !== 'Unpaid')
        {
            return redirect()->back()->with('error','Đơn hàng đã thanh toán!');
        }
        $data['orderDescription'] =  $orderDescription;
        $data['totalAmount'] =  $amount;
        $data['orderId'] =  $order->code;
        $data['order'] = $order;
        $subquery = \App\Models\Product::select('id','title');
        $data['details'] = \App\Models\OrderDetail::where('wo_id', $order->order_id)
            
            ->joinSub($subquery, 'products', function ($join) {
                $join->on('order_details.product_id', '=', 'products.id');
            })
            ->select(
                'order_details.*', 
                'products.title', 
              
            )
            ->get();
        // dd($data);
        return view($this->front_view.'.cart.online_payment',$data);

    }


    public function processVnpayPayment(Request $request)
    {
        $orderId = $request->input('order_id');
        $amount = $request->input('amount');

        $vnp_TmnCode = env('VNP_TMN_CODE');
        $vnp_HashSecret = env('VNP_HASH_SECRET');
        $vnp_Url = env('VNP_URL');
        $vnp_Returnurl = route('vnpay_return');

        $vnp_TxnRef = $orderId;
        $vnp_OrderInfo = "Thanh toán đơn hàng #" . $orderId;
        $vnp_Amount = $amount * 100;
        $vnp_CreateDate = date('YmdHis');
        $vnp_IpAddr = $request->ip();

        $inputData = [
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => $vnp_CreateDate,
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => "vn",
            "vnp_OrderInfo" => $vnp_OrderInfo,
            "vnp_OrderType" => "billpayment",
            "vnp_ReturnUrl" => $vnp_Returnurl,
            "vnp_TxnRef" => $vnp_TxnRef,
        ];

        ksort($inputData);
        $query = http_build_query($inputData);
        $vnp_SecureHash = hash_hmac('sha512', $query, $vnp_HashSecret);
        $vnpUrl = $vnp_Url . "?" . $query . "&vnp_SecureHash=" . $vnp_SecureHash;

        return redirect($vnpUrl);
    }

    public function vnpayReturn(Request $request)
    {
        $vnp_HashSecret = env('VNP_HASH_SECRET'); // Chuỗi bí mật từ VNPAY
        $inputData = [];
        foreach ($request->all() as $key => $value) {
            if (substr($key, 0, 4) == "vnp_") {
                $inputData[$key] = $value;
            }
        }

        $vnp_SecureHash = $inputData['vnp_SecureHash'];
        unset($inputData['vnp_SecureHash']);
        ksort($inputData);

        $hashData = "";
        foreach ($inputData as $key => $value) {
            $hashData .= urlencode($key) . '=' . urlencode($value) . '&';
        }
        $hashData = rtrim($hashData, '&');

        $secureHash = hash_hmac('sha512', $hashData, $vnp_HashSecret);

        if ($secureHash == $vnp_SecureHash) {
            if ($inputData['vnp_ResponseCode'] == '00') {
                // Thanh toán thành công
                $orderId = $inputData['vnp_TxnRef']; // Mã đơn hàng từ VNPAY (wo_id)
                $amount = $inputData['vnp_Amount'] / 100;
                $transactionNo = $inputData['vnp_TransactionNo'];
                $bankCode = $inputData['vnp_BankCode'] ?? null;
                $transactionDate = $inputData['vnp_PayDate'];

                // Lưu thông tin vào bảng `order_trans`


                // Lưu thông tin vào bảng `payment_trans`
                $paymentTrans = DB::table('payment_trans')->insert([
                    'gateway' => 'VNPAY',
                    'account_number' => $bankCode,
                    'order_id' => $orderId,
                    'amount_in' => $amount,
                    'transaction_content' => 'Thanh toán đơn hàng MEM' . str_pad($orderId, 9, '0', STR_PAD_LEFT),
                    'reference_number' => $transactionNo,
                    'body' => json_encode($inputData),
                    'transaction_date' => date('Y-m-d H:i:s', strtotime($transactionDate)),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
                $order_trans = \App\Models\OrderTrans::where('code', $orderId)->first();
                if ($order_trans && $order_trans->status == 'Unpaid') {
                    $order_trans->status = 'Paid';
                    $order_trans->save();
                    $order = \App\Models\Order::find($order_trans->order_id);
                    if ($order) {
                        $order->status = 'Paid';
                        $order->save();
                        //tang tien quy cho khach hang
                        $userController = new \App\Http\Controllers\UserController();
                        $user_id = $order->customer_id;
                        $userController->moneyUserpaymentOnline($user_id, $amount, 2);
                    }
                }

                return view('frontend_tp.cart.vnpay_result', [
                    'status' => 'success',
                    'orderId' => $orderId,
                    'amount' => $amount,
                    'transactionNo' => $transactionNo,
                    'message' => 'Giao dịch thành công',
                ]);
            } else {
                return view('frontend_tp.cart.vnpay_result', [
                    'status' => 'failed',
                    'message' => 'Giao dịch không thành công',
                ]);
            }
        } else {
            return view('frontend_tp.cart.vnpay_result', [
                'status' => 'failed',
                'message' => 'Sai chữ ký',
            ]);
        }
    }
}
