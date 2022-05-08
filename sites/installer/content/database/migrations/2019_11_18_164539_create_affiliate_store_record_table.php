<?php

use Royalcms\Component\Database\Schema\Blueprint;
use Royalcms\Component\Database\Migrations\Migration;

class CreateAffiliateStoreRecordTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (RC_Schema::hasTable('affiliate_store_record')) {
            return ;
        }

        /**
         * 代理商邀请关系记录表
         */
        RC_Schema::create('affiliate_store_record', function (Blueprint $table) {
            $table->integer('id');
            $table->integer('affiliate_store_id')->unsigned()->default('0')->comment('代理商id');
            $table->integer('user_id')->unsigned()->default('0')->comment('用户id，只做记录，不可关联');
            $table->integer('store_id')->unsigned()->nullable()->comment('店铺id');
            $table->integer('store_preaudit_id')->unsigned()->nullable()->comment('预入驻店铺id');
            $table->integer('add_time')->unsigned()->default('0');

            $table->unique('store_id', 'store_id');
            $table->unique('store_preaudit_id', 'store_preaudit_id');
            $table->index('affiliate_store_id', 'affiliate_store_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        RC_Schema::drop('affiliate_store_record');
    }
}
