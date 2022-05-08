<?php

use Royalcms\Component\Database\Schema\Blueprint;
use Royalcms\Component\Database\Migrations\Migration;

class CreateUcenterOpenidsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (RC_Schema::hasTable('ucenter_openids')) {
            return ;
        }

        RC_Schema::create('ucenter_openids', function (Blueprint $table) {
            $table->string('openid', 60);
            $table->integer('appid')->unsigned()->default('0')->comment('应用ID');
            $table->integer('user_id')->unsigned()->default('0')->comment('用户ID');
            $table->string('user_name', 60)->comment('用户名称');
            $table->integer('create_time')->unsigned()->default('0')->comment('首次登录时间');
            $table->integer('login_times')->unsigned()->default('1')->comment('登录次数');
            $table->integer('last_time')->unsigned()->default('0')->comment('最后一次登录时间');

            $table->primary('openid', 'openid');
            $table->unique(['appid', 'user_id'], 'appid_userid');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        RC_Schema::drop('ucenter_openids');
    }
}
