<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\ShopingCart;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Support\Facades\Auth;

class ShopingCartController extends Controller
{
    // Định nghĩa thuộc tính $front_view
    protected $front_view = 'frontend_tp'; // Thay 'frontend_tp' bằng namespace thư mục view của bạn

    public function viewCart()
    {
        $data['detail'] = \App\Models\SettingDetail::find(1);
        $data['categories'] = \App\Models\Category::where('status', 'active')->where('parent_id', null)->get();
        ////
        $data['pagetitle'] = " Giỏ hàng ";
        $data['links'] = array();
        $link = new \App\Models\Links();
        $link->title = 'Giỏ hàng';
        $link->url = '#';
        array_push($data['links'], $link);
        ///
        $user = auth()->user();
        if ($user) {
            $sql  = "select c.quantity, d.* from (SELECT * from shoping_carts where user_id = "
                . $user->id . ") as c left join products as d on c.product_id = d.id where d.status = 'active'  ";
            $data['products'] =   DB::select($sql);
            $sql_new_blog = "SELECT * from products where status = 'active' and stock >= 0  order by id desc LIMIT 6";
            $data['newpros'] =   DB::select($sql_new_blog);

            return view($this->front_view . '.cart.view', $data);
        } else {
            return view($this->front_view . '.auth.login', $data);
        }
    }

    public function checkout()
    {
        $user = auth()->user();

        if (!$user) {
            return redirect()->route('front.login');
        }

        $data['detail'] = \App\Models\SettingDetail::find(1);
        $data['categories'] = \App\Models\Category::where('status', 'active')->get();
        $data['products'] = DB::table('shoping_carts')
            ->join('products', 'shoping_carts.product_id', '=', 'products.id')
            ->where('shoping_carts.user_id', $user->id)
            ->select('shoping_carts.quantity', 'products.*')
            ->get();
        $data['addressbooks'] = \App\Models\AddressBook::where('user_id', $user->id)->get();
        $data['paymentinfo'] = \App\Models\SettingDetail::find(1)->paymentinfo;

        // Thêm biến `$defaut_setting` vào dữ liệu truyền vào view
        $data['defaut_setting'] = \App\Models\UserSetting::where('user_id', $user->id)->first();
        $data['invoiceaddress'] = $data['defaut_setting'] && $data['defaut_setting']->invoice_id
            ? \App\Models\AddressBook::find($data['defaut_setting']->invoice_id)
            : null;

        $data['shipaddress'] = $data['defaut_setting'] && $data['defaut_setting']->ship_id
            ? \App\Models\AddressBook::find($data['defaut_setting']->ship_id)
            : null;

        return view(
            'frontend_tp.cart.checkout',
            $data
        );
    }




    public function order(Request $request)
    {
        $user = auth()->user();

        if (!$user) {
            return redirect()->route('front.login');
        }

        // Xác thực dữ liệu đầu vào
        $this->validate($request, [
            'payment_method' => 'required|in:cod,online',
            'ship_id' => 'required|numeric',
            'invoice_id' => 'required|numeric',
        ]);

        // Lấy thông tin giỏ hàng
        $cartItems = DB::table('shoping_carts')
            ->join('products', 'shoping_carts.product_id', '=', 'products.id')
            ->where('shoping_carts.user_id', $user->id)
            ->select('shoping_carts.quantity', 'products.price', 'products.id')
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('front.cart.view')->with('error', 'Giỏ hàng trống.');
        }

        // Tính tổng giá trị đơn hàng
        $totalAmount = 0;
        foreach ($cartItems as $item) {
            $totalAmount += $item->quantity * $item->price;
        }

        // Tạo đơn hàng
        $order = Order::create([
            'customer_id' => $user->id,
            'vendor_id' => 0,
            'wh_id' => 0,
            'final_amount' => $totalAmount,
            'discount_amount' => 0,
            'paid_amount' => 0,
            'is_paid' => 0,
            'cost_extra' => 0,
            'status' => 'pending',
            'full_name' => $request->full_name ?? $user->name,
            'phone' => $request->phone ?? $user->phone,
            'address' => $request->address ?? '',
        ]);

        // Tạo chi tiết đơn hàng
        foreach ($cartItems as $item) {
            OrderDetail::create([
                'wo_id' => $order->id,
                'product_id' => $item->id,
                'quantity' => $item->quantity,
                'price' => $item->price,
            ]);
        }

        // Xóa giỏ hàng sau khi đặt hàng
        DB::table('shoping_carts')->where('user_id', $user->id)->delete();

        // Nếu chọn thanh toán online, chuẩn bị dữ liệu và chuyển hướng
        if ($request->payment_method === 'online') {
            return redirect()->route('payment.online', [
                'order_id' => $order->id,
                'amount' => $totalAmount,
                'order_desc' => 'Thanh toán đơn hàng ' . $order->id,
            ]);
        }

        // Nếu chọn thanh toán COD, chuyển hướng tới danh sách đơn hàng
        return redirect()->route('front.profile.order')->with('success', 'Đơn hàng đã được tạo thành công!');
    }



    public function getList()
    {
        $user = auth()->user();
        if ($user) {
            $sql  = "select c.quantity, d.* from (SELECT * from shoping_carts where user_id = "
                . $user->id . ") as c left join products as d on c.product_id = d.id where d.status = 'active'  ";
            $products =   DB::select($sql);
            return response()->json(['status' => true, 'products' => $products]);
        } else {
            return response()->json(['status' => false, 'products' => null]);
        }
    }
    public function add(Request $request)
    {
        $this->validate($request, [
            'product' => 'required',
        ]);
        $user = auth()->user();
        if ($user) {
            $product = $request->product;
            // dd($product);
            $data['quantity'] =  $product['quantity'];
            $data['product_id'] =  $product['id'];
            $data['user_id'] = $user->id;
            $wish = ShopingCart::where('product_id', $data['product_id'])
                ->where('user_id', $user->id)->first();
            if (!$wish) {
                $wish = ShopingCart::create($data);
                $msg = "Thêm thành công";
            } else {
                $wish->quantity +=  $data['quantity'];
                $wish->save();
                $msg = "Đã thêm số lượng " . $data['quantity'];
            }
            $sql  = "select c.quantity, d.* from (SELECT * from shoping_carts where user_id = "
                . $user->id . ") as c left join products as d on c.product_id = d.id where d.status = 'active'  ";
            $products =   DB::select($sql);
            return response()->json(['msg' => $msg, 'status' => true, 'products' => $products]);
        } else {
            return response()->json(['msg' => "Bạn phải đăng nhập để thực hiện", 'status' => false]);
        }
    }

    // public function add(Request $request)
    // {
    //     $this->validate($request, [
    //         'product' => 'required',
    //     ]);

    //     $user = auth()->user();
    //     if ($user) {
    //         $product = $request->product;
    //         $data['quantity'] = $product['quantity'];
    //         $data['product_id'] = $product['id'];
    //         $data['user_id'] = $user->id;

    //         $wish = ShopingCart::where('product_id', $data['product_id'])
    //             ->where('user_id', $user->id)->first();

    //         if (!$wish) {
    //             $wish = ShopingCart::create($data);
    //             $msg = "Thêm thành công";
    //         } else {
    //             $wish->quantity += $data['quantity'];
    //             $wish->save();
    //             $msg = "Đã thêm số lượng " . $data['quantity'];
    //         }

    //         $products = DB::table('shoping_carts')
    //             ->join('products', 'shoping_carts.product_id', '=', 'products.id')
    //             ->where('shoping_carts.user_id', $user->id)
    //             ->where('products.status', 'active')
    //             ->select('shoping_carts.quantity', 'products.*')
    //             ->get();

    //         return response()->json(['msg' => $msg, 'status' => true, 'products' => $products]);
    //     } else {
    //         return response()->json(['msg' => "Bạn phải đăng nhập để thực hiện", 'status' => false]);
    //     }
    // }

    public function update(Request $request)
    {
        $this->validate($request, [
            'product_id' => 'numeric|required',
            'quantity' => 'numeric|required',
        ]);
        $user = auth()->user();
        if ($user) {
            $wish = ShopingCart::where('product_id', $request->product_id)
                ->where('user_id', $user->id)->first();
            if ($wish) {
                if ($request->quantity > 0) {
                    $wish->quantity =  $request->quantity;
                    $wish->save();
                    $msg = "Đã cập nhật số lượng " . $request->quantity;
                } else {
                    $wish->delete();
                    $msg = "Đã cập xóa khỏi giỏ hàng";
                }
            } else {
                $msg = "Không tìm thấy ";
            }
            $sql  = "select c.quantity, d.* from (SELECT * from shoping_carts where user_id = "
                . $user->id . ") as c left join products as d on c.product_id = d.id where d.status = 'active'  ";
            $products =   DB::select($sql);
            return response()->json(['msg' => $msg, 'status' => true, 'products' => $products]);
        } else {
            return response()->json(['msg' => "Bạn phải đăng nhập để thực hiện", 'status' => false]);
        }
    }
}
