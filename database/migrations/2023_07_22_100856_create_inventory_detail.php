<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('inventory_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('inventory_id')->default(0) ;
            $table->enum('doc_type',['wi','mi','ui','ti','pi','ic','wo','din','dout'])->default('wi');
            //din là trả lại hàng nhập hoặc hủy đơn, xóa chi tiết nhập hàng
            $table->unsignedBigInteger('wh_id')->default(0) ;
            $table->unsignedBigInteger('product_id') ;
            $table->integer('quantity');
            $table->integer('prebalance')->default(0);
            $table->unsignedInteger('price');
            
            $table->unsignedBigInteger('doc_id')->default(0);
            $table->dateTime('expired_at')->nullable();
            $table->integer('benefit')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventory_details');
    }
};
