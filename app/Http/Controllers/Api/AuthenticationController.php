<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Storage;

class AuthenticationController extends Controller
{
    public function store()
    {
        if (Auth::attempt(['email' => request('email'), 'password' => request('password')])) {
            // successful authentication
            $user = User::find(Auth::user()->id);
            if ($user->status == 'inactive') {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to authenticate.',
                ], 401);
            } else {
                $user_token['token'] = $user->createToken('appToken')->accessToken;

                return response()->json([
                    'success' => true,
                    'token' => $user_token,
                    'user' => $user,
                ], 200);
            }
        } else {
            // failure to authenticate
            return response()->json([
                'success' => false,
                'message' => 'Failed to authenticate.',
            ], 401);
        }
    }

    /**
     * Destroy an authenticated session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Request $request)
    {
        if (Auth::user()) {
            $request->user()->token()->revoke();

            return response()->json([
                'success' => true,
                'message' => 'Logged out successfully',
            ], 200);
        }

        return response()->json([
            'success' => false,
            'message' => 'User not authenticated',
        ], 401); // Xử lý trường hợp khi người dùng không được xác thực
    }
    public function saveNewUser(Request $request)
{
    // Kiểm tra và xác thực dữ liệu đầu vào
    $validator = Validator::make($request->all(), [
        'full_name'   => 'string|required',
        'description' => 'string|nullable',
        'phone'       => 'string|required|regex:/^[0-9]{10}$/', // Kiểm tra số điện thoại 10 chữ số
        'email'       => 'string|required|email|unique:users,email', // Kiểm tra email hợp lệ và không trùng
        'password'    => 'string|required|min:8|', // Mật khẩu tối thiểu 8 ký tự và xác nhận mật khẩu
        'address'     => 'string|required',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'success' => false,
            'message' => $validator->errors(),
        ], 400); // Trả về lỗi với mã trạng thái 400 nếu xác thực không thành công
    }
    
    $data = $request->all();
    
    // Kiểm tra nếu số điện thoại đã tồn tại
    $olduser = \App\Models\User::where('phone', $data['phone'])->first();
    if ($olduser) {
        return response()->json([
            'success' => false,
            'message' => 'Số điện thoại đã tồn tại!',
        ], 400); // Trả về lỗi khi số điện thoại đã tồn tại
    }

    // Kiểm tra nếu email đã tồn tại
    $olduser = \App\Models\User::where('email', $data['email'])->first();
    if ($olduser) {
        return response()->json([
            'success' => false,
            'message' => 'Email đã tồn tại!',
        ], 400); // Trả về lỗi khi email đã tồn tại
    }

    // Thiết lập ảnh mặc định
    $data['photo'] = asset('backend/assets/dist/images/profile-6.jpg');
    // Mã hóa mật khẩu
    $data['password'] = Hash::make($data['password']);
    // Đặt username là số điện thoại
    $data['username'] = $data['phone'];
    $data['role'] = 'customer'; // Thiết lập role mặc định

    // Tạo người dùng mới
    $status = \App\Models\User::c_create($data);
    
    if (!$status) {
        return response()->json([
            'success' => false,
            'message' => 'Lỗi xảy ra khi tạo người dùng!',
        ], 500); // Trả về lỗi khi không thể tạo người dùng
    }

    // Trả về thông báo thành công
    return response()->json([
        'success' => true,
        'message' => 'Đăng ký thành công!',
    ], 200);
}
// Xử lý cập nhật profile trong controller (Laravel ví dụ)
public function updateProfile(Request $request) {
    // Validate input dữ liệu
    $data = $request->validate([
        'full_name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'phone' => 'nullable|string',
        'address' => 'nullable|string',
        'photo' => 'nullable|image', // Validate ảnh nếu có
    ]);

    // Lấy thông tin người dùng hiện tại
    $user = Auth::user();
    $user->full_name = $data['full_name'];
    $user->email = $data['email'];
    $user->phone = $data['phone'];
    $user->address = $data['address'];

    // Kiểm tra nếu người dùng có gửi ảnh mới
    if ($request->hasFile('photo')) {
        // Xóa ảnh cũ nếu có
        if ($user->photo) {
            // Xóa ảnh cũ khỏi storage
            Storage::delete('public/' . $user->photo);
        }

        // Lưu ảnh mới vào thư mục 'avatars'
        $photo = $request->file('photo');
        $photoPath = $photo->store('avatars', 'public'); // Lưu ảnh trong thư mục 'avatars'

        // Lưu đường dẫn đầy đủ vào cơ sở dữ liệu
        $user->photo = 'http://127.0.0.1:8000/storage/avatar/' . basename($photoPath); // Lưu đường dẫn ảnh mới
    }

    // Lưu thông tin người dùng đã cập nhật
    $user->save();

    // Trả về phản hồi
    return response()->json([
        'message' => 'Profile updated successfully',
        'user' => $user,
    ]);
}



public function getProfile(Request $request)
{
    // Lấy thông tin người dùng đã đăng nhập
    $user = Auth::user();  // Sử dụng Auth để lấy người dùng hiện tại

    // Nếu không có người dùng đăng nhập, trả về lỗi 401
    if (!$user) {
        return response()->json(['message' => 'Unauthorized'], 401);
    }

    // Trả về thông tin người dùng dưới dạng JSON
    return response()->json([
        'full_name' => $user->full_name,
        'email' => $user->email,
        'phone' => $user->phone,
        'address' => $user->address,
        'photo' => $user->photo, // URL ảnh của người dùng (nếu có)
    ]);
}

       

    
}
