<?php

use Royalcms\Component\Database\Schema\Blueprint;
use Royalcms\Component\Database\Migrations\Migration;

class AddColumnStoreIdToProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (! RC_Schema::hasTable('products')) {
            return ;
        }

        //添加字段
        RC_Schema::table('products', function (Blueprint $table) {
            if (!RC_Schema::hasColumn('products', 'store_id')) $table->integer('store_id')->unsigned()->default(0)->comment('店铺id');
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
        RC_Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('store_id');
        });
    }
}
