<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Exception;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * Các trường có thể gán giá trị hàng loạt.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'code',
        'global_id',
        'full_name',
        'username',
        'email',
        'password',
        'email_verified_at',
        'photo',
        'phone',
        'address',
        'description',
        'ship_id',
        'ugroup_id',
        'role',
        'budget',
        'totalpoint',
        'totalrevenue',
        'taxcode',
        'taxname',
        'taxaddress',
        'status',
    ];

    /**
     * Các trường bị ẩn khi JSON hóa.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Các trường cần được chuyển đổi kiểu dữ liệu.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed', // Đảm bảo Laravel hỗ trợ thuộc tính này
    ];

    /**
     * Xóa người dùng hoặc đặt trạng thái "inactive" tùy theo quyền.
     *
     * @param int $user_id
     * @return int
     */
    public static function deleteUser($user_id)
    {
        $user = User::find($user_id);

        if (!$user) {
            return -1; // Người dùng không tồn tại
        }

        if (auth()->user()->role == 'admin') {
            $user->delete();
            return 1; // Đã xóa
        } else {
            $user->status = "inactive";
            $user->save();
            return 0; // Đánh dấu là không hoạt động
        }
    }

    /**
     * Tạo người dùng mới và gán mã duy nhất.
     *
     * @param array $data
     * @return User
     */
    public static function c_create($data)
    {
        $user = User::create($data);

        // Gán mã người dùng
        $user->code = "CUS" . sprintf('%09d', $user->id);
        $user->save();

        return $user;
    }

    /**
     * Cập nhật ngân sách người dùng (budget).
     *
     * @param float $operation (+1 hoặc -1)
     * @param float $amount
     * @param int|null $transaction_id
     * @param string|null $type
     * @return bool
     * @throws Exception
     */
    public function update_budget($operation, $amount, $transaction_id = null, $type = null)
    {
        // Kiểm tra nếu cột 'budget' tồn tại trong database
        if (!Schema::hasColumn('users', 'budget')) {
            throw new Exception("Cột 'budget' không tồn tại trong bảng users.");
        }

        // Kiểm tra giá trị hợp lệ
        if (!is_numeric($amount) || !in_array($operation, [-1, 1])) {
            throw new Exception("Giá trị không hợp lệ cho update_budget.");
        }

        // Cập nhật ngân sách
        $this->budget += $operation * $amount;
        $this->save();

        // Ghi log
        Log::info("User {$this->id} cập nhật ngân sách: {$this->budget} (operation: $operation, amount: $amount)");

        return true;
    }

    /**
     * Cập nhật thông tin người dùng.
     *
     * @param array $data
     * @return bool
     */
    public static function c_update($data)
    {
        $user = User::find($data['id']);

        if ($user) {
            $user->fill($data);
            return $user->save();
        }

        return false;
    }
}
