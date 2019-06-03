<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateBlogStoriesTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('blog_stories', function (Blueprint $table) {
            $table->renameColumn('name', 'title');
            $table->string('sub_title')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('blog_stories', function (Blueprint $table) {
            $table->renameColumn('title', 'name');
            $table->dropColumn('sub_title');
        });
    }

}
