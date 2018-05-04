<?php

use Royalcms\Component\Database\Schema\Blueprint;
use Royalcms\Component\Database\Migrations\Migration;

class AddUserMoneyForExpressUserTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		RC_Schema::table('express_user', function(Blueprint $table)
		{
		    $table->string('province', 20)->nullable()->after('comment_rank');
		    $table->string('city', 20)->nullable()->after('province');
		    $table->string('district', 20)->nullable()->after('city');
		    $table->string('street', 20)->nullable()->comment('街道地区码')->after('district');
		    $table->string('address', 200)->nullable()->comment('详细地址')->after('street');
		    $table->tinyInteger('work_type')->unsigned()->default('1')->comment('配送员工作类型（1派单，2抢单）')->after('address');
		    $table->decimal('user_money', 10, 2)->default('0.00')->comment('总账户余额')->after('work_type');
		    $table->tinyInteger('shippingfee_percent')->unsigned()->default('0')->comment('配送费用比例')->after('user_money');
		    $table->string('apply_source', 60)->nullable()->comment('配送员申请来源')->after('shippingfee_percent');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		RC_Schema::table('express_user', function(Blueprint $table)
		{
		    $table->dropColumn('province');
		    $table->dropColumn('city');
		    $table->dropColumn('district');
		    $table->dropColumn('street');
		    $table->dropColumn('address');
		    $table->dropColumn('work_type');
		    $table->dropColumn('user_money');
		    $table->dropColumn('shippingfee_percent');
		    $table->dropColumn('apply_source');
		});
	}

}
