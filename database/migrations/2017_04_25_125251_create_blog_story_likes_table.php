<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBlogStoryLikesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blog_story_likes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('story_id')->unsigned()->index();
            $table->integer('creator_id')->unsigned()->index();
            $table->timestamps();
            $table->foreign('story_id')->references('id')->on('blog_stories')->onDelete('cascade');
            $table->foreign('creator_id')->references('id')->on('users')->onDelete('cascade');
        });
        Schema::table('blog_stories', function (Blueprint $table) {
            $table->bigInteger('count_likes')->default(0);
        });
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('blog_story_likes');
        Schema::table('blog_stories', function (Blueprint $table) {
            $table->dropColumn('count_likes');
        });
    }
}
