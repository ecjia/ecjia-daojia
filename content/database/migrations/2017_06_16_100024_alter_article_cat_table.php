<?php

use Royalcms\Component\Database\Schema\Blueprint;
use Royalcms\Component\Database\Migrations\Migration;

class AlterArticleCatTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
	    RC_Schema::table('article_cat', function(Blueprint $table)
	    {
	        $table->dropColumn('cat_type');
	    });
	    
		RC_Schema::table('article_cat', function(Blueprint $table)
		{
		    $table->string('cat_type', 60)->default('article')->index('cat_type')->after('cat_name');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
	    RC_Schema::table('article_cat', function(Blueprint $table)
	    {
	        $table->dropColumn('cat_type');
	    });
	    
		RC_Schema::table('article_cat', function(Blueprint $table)
		{
			$table->tinyInteger('cat_type')->unsigned()->default('1')->index('cat_type')->after('cat_name');
		});
	}

}
