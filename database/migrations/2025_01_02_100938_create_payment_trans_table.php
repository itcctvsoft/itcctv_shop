<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payment_trans', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('gateway'); // Cổng thanh toán
            $table->string('account_number'); // Số tài khoản
            $table->string('sub_account')->nullable(); // Tài khoản phụ (nếu có)
            $table->unsignedBigInteger('order_id')->nullable(); // ID đơn hàng (nếu có)
            $table->decimal('amount_in', 15, 2)->nullable(); // Số tiền nhận vào
            $table->decimal('amount_out', 15, 2)->nullable(); // Số tiền ra
            $table->string('code')->nullable(); // Mã giao dịch
            $table->string('transaction_content')->nullable(); // Nội dung giao dịch
            $table->string('reference_number')->nullable(); // Số tham chiếu
            $table->text('body')->nullable(); // Nội dung chi tiết
            $table->dateTime('transaction_date')->nullable(); // Ngày giao dịch
            $table->timestamps(); // Thời gian tạo và cập nhật
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payment_trans');
    }
};
