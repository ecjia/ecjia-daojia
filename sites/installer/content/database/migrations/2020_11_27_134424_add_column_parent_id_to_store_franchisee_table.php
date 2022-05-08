<?php

use Royalcms\Component\Database\Schema\Blueprint;
use Royalcms\Component\Database\Migrations\Migration;

class AddColumnParentIdToStoreFranchiseeTable extends Migration
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

        //添加字段
        RC_Schema::table('store_franchisee', function (Blueprint $table) {
            if (!RC_Schema::hasColumn('store_franchisee', 'parent_id')) $table->integer('parent_id')->unsigned()->default('0')->comment('上级商家ID');
            if (!RC_Schema::hasColumn('store_franchisee', 'out_store_id')) $table->integer('out_store_id')->unsigned()->nullable()->default('0')->comment('对应外部店铺ID（主店铺或子店铺ID）');
            if (!RC_Schema::hasColumn('store_franchisee', 'out_store_type')) $table->string('out_store_type', 30)->nullable()->default('')->comment('对应外部店铺来源类型，如：dscmall');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //删除字段
        RC_Schema::table('store_franchisee', function (Blueprint $table) {
            $table->dropColumn('parent_id');
            $table->dropColumn('out_store_id');
            $table->dropColumn('out_store_type');
        });
    }
}
