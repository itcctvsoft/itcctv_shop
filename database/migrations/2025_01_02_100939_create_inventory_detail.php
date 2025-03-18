<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inventory_details', function (Blueprint $table) {
            $table->id();
            $table->string('gateway'); // Cổng thanh toán
            $table->unsignedBigInteger('inventory_id'); // Số tài khoản
            $table->string('doc_type')->nullable(); // Tài khoản phụ (nếu có)
            $table->integer('wh_id')->nullable(); // ID đơn hàng (nếu có)
            $table->unsignedBigInteger('inventory_id'); // Số tài khoản
            $table->integer('quantity') ;
            $table->integer('operation') ;
            $table->unsignedBigInteger('prebalance'); // Số tài khoản
            $table->unsignedBigInteger('price'); // Số tài khoản
            $table->unsignedBigInteger('doc_id'); // Số tài khoản
          
            $table->dateTime('expired_at')->nullable(); // Ngày giao dịch
            $table->unsignedBigInteger('benefit'); // Số tài khoản
            $table->timestamps(); // Thời gian tạo và cập nhật
           
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inventory_details');
    }
};
