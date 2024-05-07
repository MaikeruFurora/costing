<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCostingHeadersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('costing_headers', function (Blueprint $table) {
            $table->id();
            $table->string('costingHeaderNo',50)->nullable();
            $table->unsignedBigInteger('warehouse_origin_id');
            $table->foreign('warehouse_origin_id')->references('id')->on('warehouse_origin')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('trucktype_id');
            $table->foreign('trucktype_id')->references('id')->on('trucktype')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->text('client')->nullable();
            $table->string('province',100)->nullable();
            $table->string('municipality',100)->nullable();
            $table->string('truckCategory',50)->nullable();
            $table->string('truckerType',50)->nullable();
            $table->string('paymentMode',50)->nullable();
            $table->string('form',50)->nullable();
            $table->string('company',50)->nullable();
            $table->string('confirmation',50)->nullable();
            $table->string('deliveryType',50)->nullable();
            $table->double('coloadQuantity',18,4)->nullable();
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
        Schema::dropIfExists('costing_headers');
    }
}
