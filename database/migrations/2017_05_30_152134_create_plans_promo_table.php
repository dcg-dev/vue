<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlansPromoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('promo_plans', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 50);
            $table->decimal('price', 6, 2);
            $table->integer('item_number');
            $table->integer('duration');
            $table->string('duration_type', 20);
            $table->boolean('enabled');
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
        Schema::dropIfExists('promo_plans');
    }
}
