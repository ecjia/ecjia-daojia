<?php

use Royalcms\Component\Database\Schema\Blueprint;
use Royalcms\Component\Database\Migrations\Migration;

class RecreatePushMessageTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
	    RC_Schema::drop('push_message');
	    
		RC_Schema::create('push_message', function(Blueprint $table)
		{
			$table->increments('message_id');
			$table->string('device_code', 60);
			$table->text('device_token')->nullable();
			$table->string('device_client', 30)->nullable()->comment('可多个批量发送，逗号分隔');
			$table->string('title', 150);
			$table->string('content', 255);
			$table->text('content_params')->nullable()->comment('内容变量参数');
			$table->integer('add_time')->unsigned()->default('0');
			$table->integer('push_time')->unsigned()->default('0')->comment('最后发送时间');
			$table->smallInteger('push_count')->unsigned()->default('0')->comment('发送次数');
			$table->string('template_id', 30)->nullable()->comment('模板ID');
			$table->tinyInteger('in_status')->unsigned()->default('0');
			$table->text('extradata')->nullable()->comment('扩展数据');
			$table->tinyInteger('priority')->default('1')->comment('0 延迟发送，1 优先发送');
			$table->string('last_error_message', 255)->nullable()->comment('最后一次错误消息');
			$table->string('msgid', 60)->nullable()->comment('厂商消息ID');
			$table->string('channel_code', 60)->nullable()->comment('推送消息渠道代码');
			
			$table->index('device_code', 'device_code');
			$table->index('channel_code', 'channel_code');
			$table->index('priority', 'priority');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		RC_Schema::drop('push_message');
		
		RC_Schema::create('push_message', function(Blueprint $table)
		{
		    $table->increments('message_id');
		    $table->integer('app_id')->unsigned()->default('0');
		    $table->char('device_token', 64)->nullable();
		    $table->char('device_client', 10)->nullable();
		    $table->string('title', 150)->nullable();
		    $table->string('content', 255)->nullable();
		    $table->integer('add_time')->unsigned()->default('0');
		    $table->integer('push_time')->unsigned()->default('0');
		    $table->tinyInteger('push_count')->unsigned()->default('0');
		    $table->mediumInteger('template_id')->unsigned()->default('0');
		    $table->tinyInteger('in_status')->unsigned()->default('0');
		    $table->text('extradata')->nullable();
		});
	}

}
