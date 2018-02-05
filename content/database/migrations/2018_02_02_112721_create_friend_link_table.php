<?php

use Royalcms\Component\Database\Schema\Blueprint;
use Royalcms\Component\Database\Migrations\Migration;

class CreateFriendLinkTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		RC_Schema::create('friend_link', function(Blueprint $table)
		{
			$table->increments('link_id');
			$table->string('link_name');
			$table->string('link_url');
			$table->string('link_logo')->nullable();
			$table->string('link_target', 20)->nullable()->default('_blank');
			$table->tinyInteger('show_order')->unsigned()->default('50');
			$table->tinyInteger('status')->default('0');
			$table->string('contact', 30)->nullable()->comment('联系人');
			$table->string('mobile', 60)->nullable()->comment('联系人手机');
			$table->string('description')->nullable();
			$table->integer('update_time')->unsigned()->default('0')->comment('添加/更新时间');
			$table->integer('apply_time')->unsigned()->nullable()->comment('申请时间');
			$table->integer('confirm_time')->unsigned()->nullable()->comment('确认时间');
			
			$table->index('show_order', 'show_order');
			$table->index('status', 'status');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		RC_Schema::drop('friend_link');
	}

}
