<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('price_index_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('warehouse_origin_id')->nullable();
            $table->foreign('warehouse_origin_id')->references('id')->on('warehouse_origin')->onDelete('cascade')->onUpdate('cascade');
            $table->string('company',50)->nullable();
            $table->string('condition',50)->nullable();
            $table->string('quantity',50)->nullable();
            $table->string('itemcode',50)->nullable();
            $table->string('itemname',50)->nullable();
            $table->decimal('pickupPrice',18,4)->nullable();
            $table->decimal('volumePrice',18,4)->nullable();
            $table->string('sku',50)->nullable();
            $table->string('brand',50)->nullable();
            $table->string('taxcode',50)->nullable();
            $table->string('area',50)->nullable();
            $table->string('basis',50)->nullable();
            $table->string('action',50)->nullable();
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
        Schema::dropIfExists('price_index_logs');
    }
};