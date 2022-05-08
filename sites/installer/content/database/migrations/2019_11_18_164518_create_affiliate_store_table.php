<?php

use Royalcms\Component\Database\Schema\Blueprint;
use Royalcms\Component\Database\Migrations\Migration;

class CreateAffiliateStoreTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (RC_Schema::hasTable('affiliate_store')) {
            return ;
        }

        RC_Schema::create('affiliate_store', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned()->default('0');
            $table->string('agent_name', 60)->comment('代理商名称');
            $table->integer('agent_parent_id')->unsigned()->default('0')->comment('所属A级代理商的id');
            $table->decimal('level0', 5, 2)->unsigned()->default('0.00')->comment('A级代理直接推荐获得佣金比');
            $table->decimal('level1', 5, 2)->unsigned()->default('0.00')->comment('B级代理推荐A级获得佣金比');
            $table->decimal('level2', 5, 2)->unsigned()->default('0.00')->comment('B级代理推荐获得佣金比');
            $table->integer('add_time')->unsigned()->default('0')->comment('添加时间');

            $table->unique('user_id', 'user_id');
            $table->index('agent_parent_id', 'agent_parent_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        RC_Schema::drop('affiliate_store');
    }
}
