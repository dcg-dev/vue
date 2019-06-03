<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('firstname')->nullable();
            $table->string('lastname')->nullable();
            $table->string('role')->default('user');
            $table->string('username')->unique();
            $table->string('avatar')->unique()->nullable();
            $table->string('email')->unique();
            $table->text('biography')->nullable();
            $table->bigInteger('count_followers')->default(0);
            $table->bigInteger('count_following')->default(0);
            $table->bigInteger('count_items')->default(0);
            $table->bigInteger('count_collections')->default(0);
            $table->bigInteger('count_sales')->default(0);
            $table->float('rating', 8, 2)->default(0.00);
            $table->string('password');
            $table->string('gender')->nullable();
            $table->string('facebook_id')->nullable()->unique();
            $table->string('company')->nullable();
            $table->string('country')->nullable();
            $table->string('state')->nullable();
            $table->string('city')->nullable();
            $table->string('address_1')->nullable();
            $table->string('address_2')->nullable();
            $table->boolean('show_skills')->default(1);
            $table->boolean('show_country')->default(1);
            $table->boolean('freelance')->default(1);
            $table->boolean('show_status')->default(1);
            $table->boolean('notification_release')->default(1);
            $table->boolean('notification_sale')->default(1);
            $table->boolean('notification_inbox')->default(1);
            $table->boolean('notification_comments')->default(1);
            $table->boolean('notification_reviews')->default(1);
            $table->rememberToken();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('users');
    }

}
