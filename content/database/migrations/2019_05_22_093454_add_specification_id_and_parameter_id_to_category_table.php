<?php

use Royalcms\Component\Database\Schema\Blueprint;
use Royalcms\Component\Database\Migrations\Migration;

class AddSpecificationIdAndParameterIdToCategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        RC_Schema::table('category', function (Blueprint $table) {
            $table->integer('specification_id')->unsigned()->default('0')->comment('绑定规格模板')->after('filter_attr');
            $table->integer('parameter_id')->unsigned()->default('0')->comment('绑定参数模板')->after('specification_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        RC_Schema::table('category', function (Blueprint $table) {
            $table->dropColumn('specification_id');
            $table->dropColumn('parameter_id');
        });
    }
}
