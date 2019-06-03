<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Models\Model;

class UpdateOrdersTableOnId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Model::unguard();
        $tables = [
            'orders',
            'order_items',
            'order_stories',
            'affiliate_sales',
            'affiliate_requests',
        ];
        foreach ($tables as $table) {  
            DB::statement('TRUNCATE TABLE ' . $table . ' CASCADE;');
        }

        Schema::table('order_items', function (Blueprint $table) {
            $table->dropForeign('order_items_order_id_foreign');
            $table->dropColumn('order_id');
        });
        Schema::table('order_stories', function (Blueprint $table) {
            $table->dropForeign('order_stories_order_id_foreign');
            $table->dropColumn('order_id');
        });
        Schema::table('orders', function($table) {
            $table->dropColumn('id');
        });
        Schema::table('orders', function($table) {
            $table->increments('id');
        });
        Schema::table('order_items', function (Blueprint $table) {
            $table->integer('order_id');
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
        });
        Schema::table('order_stories', function (Blueprint $table) {
            $table->integer('order_id');
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
        //
    }
}
