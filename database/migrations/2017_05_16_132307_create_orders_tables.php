<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->integer('customer_id');
            $table->float('amount', 8, 2)->default(0.00);
            $table->string('payment_type')->nullable();
            $table->string('order_status')->nullable();
            $table->string('stripe_charge_id')->nullable();
            $table->softDeletes();
            $table->timestamps();
            $table->foreign('customer_id')->references('id')->on('users')->onDelete('cascade');
        });
        
        Schema::create('order_items', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('order_id');
            $table->integer('item_id');
            $table->integer('license_id');
            $table->string('stripe_transfer_id')->nullable();
            $table->float('price', 8, 2)->default(0.00);
            $table->softDeletes();
            $table->timestamps();
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
            $table->foreign('item_id')->references('id')->on('items')->onDelete('cascade');
            $table->foreign('license_id')->references('id')->on('licenses')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
        Schema::dropIfExists('order_items');
    }
}
