<?php

use Royalcms\Component\Database\Schema\Blueprint;
use Royalcms\Component\Database\Migrations\Migration;

class CreateUcenterFailedloginsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (RC_Schema::hasTable('ucenter_failedlogins')) {
            return ;
        }

        RC_Schema::create('ucenter_failedlogins', function (Blueprint $table) {
            $table->string('ip', 60)->comment('ip 地址');
            $table->tinyInteger('count')->unsigned()->default('0')->comment('登录次数');
            $table->integer('lastupdate')->unsigned()->default('0')->comment('最后更新时间');

            $table->primary('ip', 'ip');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        RC_Schema::drop('ucenter_failedlogins');
    }
}
