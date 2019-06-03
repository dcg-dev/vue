<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTypeFiledToAffilateSales extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \App\Models\AffiliateSale::truncate();
        Schema::table('affiliate_sales', function (Blueprint $table) {
            $table->integer('affiliable_id');
            $table->string('affiliable_type');
            $table->dropColumn('order_item_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('affiliate_sales', function (Blueprint $table) {
            $table->dropColumn('affiliable_id');
            $table->dropColumn('affiliable_type');
            $table->integer('order_item_id');
            $table->foreign('order_item_id')->references('id')->on('order_items')->onDelete('cascade');
        });
    }
}
