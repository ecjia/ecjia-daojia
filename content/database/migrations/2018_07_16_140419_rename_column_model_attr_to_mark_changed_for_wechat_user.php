<?php

use Royalcms\Component\Database\Schema\Blueprint;
use Royalcms\Component\Database\Migrations\Migration;

class RenameColumnModelAttrToMarkChangedForWechatUser extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		RC_Schema::table('cart', function(Blueprint $table)
		{
            $table->renameColumn('model_attr', 'mark_changed');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		RC_Schema::table('cart', function(Blueprint $table)
		{
            $table->renameColumn('mark_changed', 'model_attr');
		});
	}

}
