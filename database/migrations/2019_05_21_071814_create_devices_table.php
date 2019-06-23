<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDevicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('devices', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('uu_id')->nullable();
            $table->integer('code')->nullable();
            $table->text('token')->nullable();
            $table->timestamps();
        });

        Schema::create('device_user', function (Blueprint $table) {
            $table->bigInteger('device_id')->unsigned();
            $table->bigInteger('user_id')->unsigned();


            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');

            $table->foreign('device_id')
                ->references('id')
                ->on('devices')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('devices');
        Schema::dropIfExistsgit ('device_user');

    }
}
