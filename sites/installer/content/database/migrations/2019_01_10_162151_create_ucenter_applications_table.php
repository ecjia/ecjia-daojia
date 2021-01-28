<?php

use Royalcms\Component\Database\Schema\Blueprint;
use Royalcms\Component\Database\Migrations\Migration;

class CreateUcenterApplicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (RC_Schema::hasTable('ucenter_applications')) {
            return ;
        }

        RC_Schema::create('ucenter_applications', function (Blueprint $table) {
            $table->increments('appid')->comment('应用ID');
            $table->string('type', 60)->comment('应用类型 DISCUZ|SUPESITE|UCHOME|XSPACE|SUPEV|ECSHOP|ECMALL|其他');
            $table->string('name', 60)->comment('应用名称');
            $table->string('url', 255)->nullable()->comment('应用的URL地址');
            $table->string('authkey', 255)->nullable()->comment('应用的密钥，注意: 每个应用的密钥都不一样');
            $table->string('ip', 45)->nullable()->comment('应用的IP地址，注意：不填写的话，可能会影响速度，因为DNS解析比较耗费时间。');
            $table->string('apifilename', 60)->nullable()->comment('接口文件名称');
            $table->string('charset', 30)->nullable()->comment('应用的字符集 如: GBK|LATIN1|UTF-8');
            $table->tinyInteger('synlogin')->default('0')->comment('是否开启同步登陆');
            $table->tinyInteger('recvnote')->default('0')->comment('是否接受通知');
            $table->text('extra')->nullable()->comment('附加参数，格式为序列化后的数组');
            $table->text('allowips')->nullable()->comment('允许请求的IP');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        RC_Schema::drop('ucenter_applications');
    }
}
