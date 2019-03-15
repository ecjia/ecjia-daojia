<?php

use Royalcms\Component\Database\Schema\Blueprint;
use Royalcms\Component\Database\Migrations\Migration;

class CreateSessionLoginsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        RC_Schema::create('session_logins', function (Blueprint $table) {
            $table->string('id', 190);
            $table->integer('user_id');
            $table->string('user_type', 40);
            $table->string('user_agent', 255)->nullable()->comment('Http User Agent');
            $table->integer('login_time')->unsigned()->default('0')->comment('登录时间');
            $table->string('login_ip', 45)->nullable()->comment('登录IP地址');
            $table->string('login_ip_location', 80)->nullable()->comment('IP地址转换成的地理位置');
            $table->string('from_type', 60)->nullable()->comment('来源类型weblogin, apilogin');
            $table->string('from_value', 255)->nullable()->comment('来源选项，有值就填');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        RC_Schema::drop('session_logins');
    }
}
