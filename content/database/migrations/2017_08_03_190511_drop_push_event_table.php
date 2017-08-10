<?php

use Royalcms\Component\Database\Schema\Blueprint;
use Royalcms\Component\Database\Migrations\Migration;

class DropPushEventTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
	    RC_Schema::drop('push_event');
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
	    RC_Schema::create('push_event', function(Blueprint $table)
		{
		    $table->increments('event_id')->comment('消息事件id');
		    $table->string('event_name', 60)->comment('消息事件名称');
		    $table->string('event_code', 60)->comment('消息事件code');
		    $table->integer('app_id')->unsigned()->default('0')->comment('客户端设备id');
		    $table->integer('template_id')->unsigned()->default('0')->comment('模板id');
		    $table->tinyInteger('is_open')->default('0')->comment('是否启用');
		    $table->integer('create_time')->unsigned()->default('0');
		});
	}

}
