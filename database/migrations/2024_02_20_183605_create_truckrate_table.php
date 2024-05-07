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
        Schema::create('truckrate', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('warehouse_origin_id');
            $table->foreign('warehouse_origin_id')->references('id')->on('warehouse_origin')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('trucktype_id');
            $table->foreign('trucktype_id')->references('id')->on('trucktype')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('group_area_id')->nullable();
            $table->foreign('group_area_id')->references('id')->on('group_areas')->onDelete('cascade')->onUpdate('cascade');
            $table->string('province',50)->nullable();
            $table->string('municipality',100)->nullable();
            $table->string('rate',50)->nullable();
            $table->string('active',50)->nullable();
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
        Schema::dropIfExists('truckrate');
    }
};