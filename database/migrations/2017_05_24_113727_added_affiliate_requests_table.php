<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddedAffiliateRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('affiliate_requests', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->boolean('is_closed')->default(0);
            $table->softDeletes();
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
        Schema::table('affiliate_sales', function (Blueprint $table) {
            $table->integer('request_id')->nullable();
            $table->foreign('request_id')->references('id')->on('affiliate_requests');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('affiliate_sales', function(Blueprint $table)
        {
            $table->dropColumn('request_id');
        });
        Schema::dropIfExists('affiliate_requests');
    }
}
