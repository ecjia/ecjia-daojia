<?php

use Royalcms\Component\Database\Schema\Blueprint;
use Royalcms\Component\Database\Migrations\Migration;

class AddUserTypeToMarketActivityLog extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        //添加字段
		RC_Schema::table('market_activity_log', function(Blueprint $table)
		{
            $table->string('user_type', 60)->nullable()->default('user')->comment('用户类型，user普通会员，wechat微信用户')->after('user_id');
		});

        //修改字段
        RC_Schema::table('market_activity_log', function(Blueprint $table)
        {
            $table->string('user_id', 60)->nullable()->default('')->comment('根据user_type存放wechat_user表openid或users表user_id')->change();
            $table->string('username', 60)->nullable()->default('')->comment('会员名称或微信昵称')->change();
        });

        //修改字段名称
        RC_Schema::table('market_activity_log', function(Blueprint $table)
        {
            $table->renameColumn('username', 'user_name');
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		RC_Schema::table('market_activity_log', function(Blueprint $table)
		{
            $table->dropColumn('user_type');
		});

        //修改字段
        RC_Schema::table('market_activity_log', function(Blueprint $table)
        {
            $table->integer('user_id')->unsigned()->default('0')->comment('会员id')->change();
            $table->string('username', 25)->comment('会员名称')->change();
        });

        //修改字段名称
        RC_Schema::table('market_activity_log', function(Blueprint $table)
        {
            $table->renameColumn('user_name', 'username');
        });
	}

}
