<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Models\Model;

class UpdateAffiliateRequestsTableByMessage extends Migration
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
            'affiliate_sales',
            'affiliate_requests',
        ];
        foreach ($tables as $table) {  
            DB::statement('TRUNCATE TABLE ' . $table . ' CASCADE;');
        }
        
        Schema::table('affiliate_requests', function(Blueprint $table)
        {
            $table->text('message');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('affiliate_requests', function(Blueprint $table)
        {
            $table->dropColumn('message');
        });
    }
}
