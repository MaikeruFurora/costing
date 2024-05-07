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
        Schema::create('costing', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('costing_header_id');
            $table->foreign('costing_header_id')->references('id')->on('costing_headers')->onDelete('cascade')->onUpdate('cascade');
            $table->text('costingNo');
            $table->text('itemName')->nullable();
            $table->string('brand',50)->nullable();
            $table->string('cardCode',50)->nullable();
            $table->string('itemCode',50)->nullable();
            $table->string('taxCode',50)->nullable();
            $table->string('specialPrice',50)->nullable();
            $table->string('volumePrice',50)->nullable();
            
            $table->decimal('quantity',18,4)->nullable();
            $table->decimal('pickupPrice',18,4)->nullable();
            $table->decimal('analysisFee',18,4)->nullable();
            $table->decimal('plasticLiner',18,4)->nullable();
            $table->decimal('twoDrops',18,4)->nullable();
            $table->decimal('parking',18,4)->nullable();
            $table->decimal('trucking',18,4)->nullable();
            $table->decimal('additionalTrucking',18,4)->nullable();
            $table->decimal('tollFee',18,4)->nullable();
            $table->decimal('allowance',18,4)->nullable();
            $table->decimal('loading',18,4)->nullable();
            $table->decimal('unloading',18,4)->nullable();
            $table->decimal('additionalUnloading',18,4)->nullable();
            $table->decimal('terms',18,4)->nullable();
            $table->decimal('cleaning',18,4)->nullable();
            $table->decimal('entryFee',18,4)->nullable();
            $table->decimal('emptySack',18,4)->nullable();
            $table->decimal('others',18,4)->nullable();
            $table->decimal('sticker',18,4)->nullable();
            $table->decimal('escort',18,4)->nullable();
            $table->decimal('bankCharge',18,4)->nullable();
            $table->decimal('commision',18,4)->nullable();
            $table->decimal('serviceFee',18,4)->nullable();
            $table->decimal('allowanceWeight',18,4)->nullable();
            $table->decimal('truckScale',18,4)->nullable();
            $table->decimal('totalCosting',18,4)->nullable();
            $table->decimal('rate',18,4)->nullable();
            $table->decimal('sku',18,4)->nullable();
            
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
        Schema::dropIfExists('costing');
    }
};