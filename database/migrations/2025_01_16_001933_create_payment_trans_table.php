<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentTransTable extends Migration
{
    public function up()
    {
        Schema::create('payment_trans', function (Blueprint $table) {
            $table->id(); // bigint UNSIGNED AUTO_INCREMENT
            $table->string('gateway'); // varchar(255)
            $table->string('account_number'); // varchar(255)
            $table->string('sub_account')->nullable(); // varchar(255) DEFAULT NULL
            $table->decimal('amount_in', 15, 2)->nullable(); // decimal(15,2) DEFAULT NULL
            $table->decimal('amount_out', 15, 2)->nullable(); // decimal(15,2) DEFAULT NULL
            $table->string('code')->nullable(); // varchar(255) DEFAULT NULL
            $table->string('transaction_content')->nullable(); // varchar(255) DEFAULT NULL
            $table->string('reference_number')->nullable(); // varchar(255) DEFAULT NULL
            $table->text('body')->nullable(); // text DEFAULT NULL
            $table->dateTime('transaction_date')->nullable(); // datetime DEFAULT NULL
            $table->timestamps(); // created_at and updated_at
            $table->string('order_id'); // varchar(255)
        });
    }

    public function down()
    {
        Schema::dropIfExists('payment_trans');
    }
}
