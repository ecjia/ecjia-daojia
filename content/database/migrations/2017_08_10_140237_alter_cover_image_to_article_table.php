<?php

use Royalcms\Component\Database\Schema\Blueprint;
use Royalcms\Component\Database\Migrations\Migration;

class AlterCoverImageToArticleTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		RC_Schema::table('article', function(Blueprint $table)
		{
		    $table->string('cover_image', 100)->default('0')->nullable()->comment('文章封面图')->change();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		RC_Schema::table('article', function(Blueprint $table)
		{
			//
		});
	}

}
