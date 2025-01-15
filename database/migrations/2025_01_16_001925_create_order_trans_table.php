<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderTransTable extends Migration
{
    public function up()
    {
        Schema::create('order_trans', function (Blueprint $table) {
            $table->id(); // bigint UNSIGNED AUTO_INCREMENT
            $table->string('code'); // varchar(255)
            $table->string('item_code'); // varchar(255)
            $table->decimal('price', 15, 2); // decimal(15,2)
            $table->enum('status', ['Unpaid', 'Paid', 'Cancelled', 'Refunded'])->default('Unpaid');
            $table->timestamps(); // created_at and updated_at
            $table->string('order_id'); // varchar(255)
        });
    }

    public function down()
    {
        Schema::dropIfExists('order_trans');
    }
}
