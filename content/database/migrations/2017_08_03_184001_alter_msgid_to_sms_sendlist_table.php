<?php

use Royalcms\Component\Database\Schema\Blueprint;
use Royalcms\Component\Database\Migrations\Migration;

class AlterMsgidToSmsSendlistTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		RC_Schema::table('sms_sendlist', function(Blueprint $table)
		{
			$table->string('msgid', 60)->nullable()->comment('短信厂商的消息ID')->change();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		RC_Schema::table('sms_sendlist', function(Blueprint $table)
		{
			$table->string('msgid', 30)->nullable()->comment('短信厂商的消息ID')->change();
		});
	}

}
