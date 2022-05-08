<?php

use Royalcms\Component\Database\Schema\Blueprint;
use Royalcms\Component\Database\Migrations\Migration;

class AddColumnSpecificationIdAndParameterIdToCategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (! RC_Schema::hasTable('category')) {
            return ;
        }

        //添加字段
        RC_Schema::table('category', function (Blueprint $table) {
            if (!RC_Schema::hasColumn('category', 'specification_id')) $table->integer('specification_id')->unsigned()->default('0')->comment('绑定规格模板')->after('filter_attr');
            if (!RC_Schema::hasColumn('category', 'parameter_id')) $table->integer('parameter_id')->unsigned()->default('0')->comment('绑定参数模板')->after('specification_id');
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
        RC_Schema::table('category', function (Blueprint $table) {
            $table->dropColumn('specification_id');
            $table->dropColumn('parameter_id');
        });
    }
}
