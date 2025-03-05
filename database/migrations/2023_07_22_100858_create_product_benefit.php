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
        Schema::create('benefits', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('inventory_id')->default(0) ;
            $table->enum('item_type',['product','wi','wo','user' ,'vendor','wh'])->default('product');
            $table->unsignedBigInteger('item_id') ;
            $table->integer('prebalance')->default(0);
            $table->unsignedBigInteger('doc_id')->default(0);
            $table->unsignedBigInteger('doc_type')->default(0);
            $table->integer('benefit')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('benefits');
    }
};
