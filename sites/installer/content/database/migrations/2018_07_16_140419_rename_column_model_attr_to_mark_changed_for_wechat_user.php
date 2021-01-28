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
        if (! RC_Schema::hasTable('cart')) {
            return ;
        }

        //重命名字段
		RC_Schema::table('cart', function(Blueprint $table)
		{
            if (RC_Schema::hasColumn('cart', 'model_attr')) $table->renameColumn('model_attr', 'mark_changed');
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
