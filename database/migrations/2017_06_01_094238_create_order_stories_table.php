<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderStoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_stories', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('order_id');
            $table->string('stripe_charge_id')->nullable();
            $table->float('price', 8, 2)->default(0.00);
            $table->string('stripe_status')->nullable();
            $table->boolean('is_available')->default(0);
            $table->softDeletes();
            $table->timestamps();
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_stories');
    }
}
