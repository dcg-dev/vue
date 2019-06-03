<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddedBlogStoryCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blog_story_comments', function (Blueprint $table) {
            $table->increments('id');
            $table->text('message');
            $table->integer('likes')->default(0);
            $table->integer('story_id')->unsigned()->index();
            $table->integer('reply_id')->unsigned()->index()->nullable();
            $table->integer('sender_id')->unsigned()->index();
            $table->timestamps();
            $table->foreign('sender_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('story_id')->references('id')->on('blog_stories')->onDelete('cascade');
            $table->foreign('reply_id')->references('id')->on('blog_story_comments')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comments');
    }
}
