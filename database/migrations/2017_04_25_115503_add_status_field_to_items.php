<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddStatusFieldToItems extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('items', function (Blueprint $table) {
            $table->dropColumn('approved');
            $table->dropColumn('draft');
            $table->integer('status')->default(0);
            $table->text('decline_reason')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('items', function (Blueprint $table) {
            $table->boolean('approved')->default(0);
            $table->boolean('draft')->default(1);
            $table->dropColumn('status');
            $table->dropColumn('decline_reason');
        });
    }

}
