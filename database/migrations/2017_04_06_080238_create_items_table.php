<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItemsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('items', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('slug')->unique();
            $table->integer('creator_id')->unsigned()->index();
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->string('demo')->nullable();
            $table->string('file')->nullable();
            $table->decimal('price', 6, 2)->nullable();
            $table->boolean('loopable')->default(0);
            $table->boolean('includes_stems')->default(0);
            $table->boolean('approved')->default(0);
            $table->boolean('draft')->default(1);
            $table->timestamps();
            $table->float('rating', 8, 2)->default(0.00);
            $table->foreign('creator_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('items');
    }

}
