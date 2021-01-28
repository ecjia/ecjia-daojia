<?php

use Royalcms\Component\Database\Schema\Blueprint;
use Royalcms\Component\Database\Migrations\Migration;

class AddIndexOutStoreIdToStoreFranchiseeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (! RC_Schema::hasTable('store_franchisee')) {
            return ;
        }

        //添加索引
        RC_Schema::table('store_franchisee', function(Blueprint $table)
        {
            if (!$table->hasIndex('out_store_id')) $table->index('out_store_id', 'out_store_id');
            if (!$table->hasIndex('out_store_type')) $table->index('out_store_type', 'out_store_type');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //删除索引
        RC_Schema::table('store_franchisee', function (Blueprint $table) {
            if ($table->hasIndex('out_store_id')) $table->dropIndex('out_store_id');
            if ($table->hasIndex('out_store_type')) $table->dropIndex('out_store_type');
        });
    }
}
