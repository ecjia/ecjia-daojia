<?php

use Royalcms\Component\Database\Schema\Blueprint;
use Royalcms\Component\Database\Migrations\Migration;

class CreateRpcAccountTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (RC_Schema::hasTable('rpc_account')) {
            return ;
        }

        RC_Schema::create('rpc_account', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 100)->comment('名称');
            $table->string('token', 100)->default('')->comment('Token');
            $table->string('aeskey', 100)->default('');
            $table->string('appid', 100)->default('')->comment('AppID');
            $table->string('appsecret', 100)->default('')->comment('AppSecret');
            $table->integer('account_id')->default('0')->comment('绑定帐户ID');
            $table->string('account_type', 100)->nullable()->default('')->comment('绑定帐户类型');
            $table->text('action_list')->nullable()->comment('权限列表');
            $table->string('callback_url', 100)->nullable()->default('')->comment('回调地址');
            $table->integer('add_gmtime')->unsigned()->default('0');
            $table->integer('sort')->unsigned()->default('0')->comment('排序');
            $table->tinyInteger('status')->unsigned()->default('0')->comment('状态');

            $table->index(['account_type', 'account_id'], 'account_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        RC_Schema::drop('rpc_account');
    }
}
