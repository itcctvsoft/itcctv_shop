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
        Schema::create('setting_details', function (Blueprint $table) {
            $table->id();
            $table->string('company_name') ;
            $table->string('address') ;
            
            $table->string('logo')->nullable() ;
            $table->string('short_name')->nullable() ;
            $table->string('site_url')->nullable() ;
            $table->string('phone')->nullable();
            $table->string('icon')->nullable() ;
            $table->string('map')->nullable() ;
            $table->text('memory')->nullable();
            $table->text('keyword')->nullable();
            $table->string('mst')->nullable();
            $table->string('email')->nullable();
            $table->string('facebook')->nullable();
            $table->string('shopee')->nullable();
            $table->string('lazada')->nullable();
            $table->string('hotline')->nullable();
            $table->string('itcctv_email')->nullable();
            $table->string('itcctv_pass')->nullable();
            $table->string('public_key')->nullable();
            $table->string('web_title')->nullable();
            $table->string('paymentinfo')->nullable();
            $table->text('logo_bct')->nullable();
            $table->text('thoigiandk')->nullable();
            $table->text('nguoilienhe')->nullable();
            $table->integer('version')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('setting_details');
    }
};
