<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateItemsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('items', function (Blueprint $table) {
            $table->bigInteger('count_sales')->default(0);
            $table->bigInteger('count_rating')->default(0);
            $table->decimal('total_sales', 6, 2)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('items', function (Blueprint $table) {
            $table->dropColumn('count_sales');
            $table->dropColumn('count_rating');
            $table->dropColumn('total_sales');
        });
    }

}
