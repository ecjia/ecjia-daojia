<?php

use Royalcms\Component\Database\Schema\Blueprint;
use Royalcms\Component\Database\Migrations\Migration;

class AddColumnSpecificationIdAndParameterIdToGoodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (! RC_Schema::hasTable('goods')) {
            return ;
        }

        //添加字段
        RC_Schema::table('goods', function (Blueprint $table) {
            if (!RC_Schema::hasColumn('goods', 'specification_id')) $table->integer('specification_id')->unsigned()->default('0')->comment('绑定规格模板')->after('goods_type');
            if (!RC_Schema::hasColumn('goods', 'parameter_id')) $table->integer('parameter_id')->unsigned()->default('0')->comment('绑定参数模板')->after('specification_id');
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
        RC_Schema::table('goods', function (Blueprint $table) {
            $table->dropColumn('specification_id');
            $table->dropColumn('parameter_id');
        });
    }
}
