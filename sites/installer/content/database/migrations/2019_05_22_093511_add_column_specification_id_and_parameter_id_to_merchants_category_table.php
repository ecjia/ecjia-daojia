<?php

use Royalcms\Component\Database\Schema\Blueprint;
use Royalcms\Component\Database\Migrations\Migration;

class AddColumnSpecificationIdAndParameterIdToMerchantsCategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (! RC_Schema::hasTable('merchants_category')) {
            return ;
        }

        //添加字段
        RC_Schema::table('merchants_category', function (Blueprint $table) {
            if (!RC_Schema::hasColumn('merchants_category', 'specification_id')) $table->integer('specification_id')->unsigned()->default('0')->comment('绑定规格模板')->after('is_show');
            if (!RC_Schema::hasColumn('merchants_category', 'parameter_id')) $table->integer('parameter_id')->unsigned()->default('0')->comment('绑定参数模板')->after('specification_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //删除字段
        RC_Schema::table('merchants_category', function (Blueprint $table) {
            $table->dropColumn('specification_id');
            $table->dropColumn('parameter_id');
        });
    }
}
