<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id')->unsigned();
            $table->string('name');
            $table->string('warranty_number');
            $table->date('purchase_date');
            $table->string('image');
            $table->date('end_date_of_warranty');
            $table->integer('factor_number')->unsigned();
            $table->boolean('is_reminder')->default(false);
            $table->date('reminder_date')->nullable();
            $table->boolean('sms_reminder')->default(false);
            $table->integer('seller_phone')->unsigned();
            $table->text('store_address');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
