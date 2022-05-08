<?php

use Royalcms\Component\Database\Schema\Blueprint;
use Royalcms\Component\Database\Migrations\Migration;

class ChangeColumnKfAccountToWechatCustomerSession extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        if (! RC_Schema::hasTable('wechat_customer_session')) {
            return ;
        }

        //修改字段
        RC_Schema::table('wechat_customer_session', function(Blueprint $table)
        {
            $table->string('kf_account', 60)->nullable()->default('')->change();
            $table->string('openid', 60)->change();
        });

	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		
	}

}
