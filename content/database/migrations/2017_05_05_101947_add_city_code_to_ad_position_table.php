<?php

use Royalcms\Component\Database\Schema\Blueprint;
use Royalcms\Component\Database\Migrations\Migration;

class AddCityCodeToAdPositionTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
	    RC_Schema::table('ad_position', function(Blueprint $table)
	    {
	        $table->dropColumn('position_style');
	    });
	    
		RC_Schema::table('ad_position', function(Blueprint $table)
		{
			$table->string('position_code', 60)->after('position_name');
			$table->smallInteger('max_number')->unsigned()->default('5')->after('position_desc');
			$table->integer('city_id')->unsigned()->nullable()->after('max_number');
			$table->string('city_name', 30)->nullable()->after('city_id');
			$table->string('type', 30)->nullable()->default('adsense')->after('city_name');
			$table->integer('group_id')->unsigned()->default('0')->after('type');
			$table->tinyInteger('sort_order')->unsigned()->nullable()->default('50')->after('group_id');
			
			$table->unique(['position_code', 'city_id', 'type'], 'position_city');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		RC_Schema::table('ad_position', function(Blueprint $table)
		{
		    $table->dropUnique('position_city');
		    
		    $table->dropColumn('position_code');
		    $table->dropColumn('max_number');
		    $table->dropColumn('city_id');
		    $table->dropColumn('city_name');
		    $table->dropColumn('type');
		    $table->dropColumn('group_id');
		    $table->dropColumn('sort_order');
		});
		
		RC_Schema::table('ad_position', function(Blueprint $table)
		{
		    $table->text('position_style')->nullable();
		});
	}

}
