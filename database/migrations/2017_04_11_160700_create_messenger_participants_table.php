<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMessengerParticipantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messenger_participants', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('thread_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->boolean('is_archive')->default(false);
            $table->integer('is_star')->default(false);
            $table->integer('is_draft')->default(false);
            $table->timestamp('last_read')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('thread_id')->references('id')->on('messenger_threads')->onUpdate('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('messenger_participants');
    }
}
