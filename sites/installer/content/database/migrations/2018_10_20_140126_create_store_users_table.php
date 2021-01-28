<?php

use Royalcms\Component\Database\Schema\Blueprint;
use Royalcms\Component\Database\Migrations\Migration;

class CreateStoreUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (RC_Schema::hasTable('store_users')) {
            return ;
        }

        RC_Schema::create('store_users', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('store_id')->unsigned()->default('0')->comment('会员来源商家id');
            $table->string('store_name', 60)->nullable()->comment('会员来源商家名称');
            $table->integer('user_id')->unsigned()->default('0')->comment('会员id同users表user_id');
            $table->string('jion_scene', 60)->nullable()->comment('成为店铺会员的场景（cashier_suggest收银员推荐加入，buy店铺消费）');
            $table->string('jion_scene_str', 60)->nullable()->comment('成为店铺会员时，存储推荐者信息');
            $table->integer('add_time')->unsigned()->default('0')->comment('添加时间');
            $table->integer('last_buy_time')->unsigned()->default('0')->comment('最后一次在店铺消费时间');

            $table->unique(['store_id', 'user_id'], 'store_user_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        RC_Schema::drop('store_users');
    }
}
