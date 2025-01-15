<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('order_trans', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('code'); // Mã giao dịch
            $table->string('item_code'); // Mã mục giao dịch
            $table->unsignedBigInteger('order_id'); // ID đơn hàng
            $table->decimal('price', 15, 2); // Giá
            $table->enum('status', ['Unpaid', 'Paid', 'Cancelled', 'Refunded'])->default('Unpaid'); // Trạng thái
            $table->timestamps(); // Thời gian tạo và cập nhật
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_trans');
    }
};
