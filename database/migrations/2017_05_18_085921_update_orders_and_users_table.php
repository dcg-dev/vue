<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateOrdersAndUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function(Blueprint $table)
        {
            $table->dropColumn('stripe_charge_id');
        });
        Schema::table('order_items', function (Blueprint $table) {
            $table->renameColumn('stripe_transfer_id', 'stripe_charge_id');
            $table->string('stripe_status')->nullable();
        });
        Schema::table('users', function(Blueprint $table)
        {
            $table->renameColumn('stripe_secret_key', 'stripe_account_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function(Blueprint $table)
        {
            $table->string('stripe_charge_id')->nullable();
        });
        Schema::table('order_items', function (Blueprint $table) {
            $table->renameColumn('stripe_charge_id', 'stripe_transfer_id');
            $table->dropColumn('stripe_status');
        });
        Schema::table('orders', function(Blueprint $table)
        {
            $table->renameColumn('stripe_account_id', 'stripe_secret_key');
        });
    }
}
