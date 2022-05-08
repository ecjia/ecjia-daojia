<?php

use Royalcms\Component\Database\Schema\Blueprint;
use Royalcms\Component\Database\Migrations\Migration;

class CreateUcenterProtectedmembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (RC_Schema::hasTable('ucenter_protectedmembers')) {
            return ;
        }

        RC_Schema::create('ucenter_protectedmembers', function (Blueprint $table) {
            $table->integer('user_id')->unsigned()->default('0')->comment('用户ID');
            $table->string('user_name', 60)->comment('用户名称');
            $table->integer('appid')->unsigned()->default('0')->comment('应用ID');
            $table->integer('dateline')->unsigned()->default('0')->comment('创建时间');
            $table->string('admin', 60)->default('0')->comment('管理员');
        });
    }

    /**
     * Reverse the migrations.
     *S
     * @return void
     */
    public function down()
    {
        RC_Schema::drop('ucenter_protectedmembers');
    }
}
