<?php

use Royalcms\Component\Database\Schema\Blueprint;
use Royalcms\Component\Database\Migrations\Migration;

class AddCatTypeToGoodslibAttrTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        RC_Schema::table('goodslib_attr', function (Blueprint $table) {
            $table->string('cat_type', 60)->nullable()->comment('规格：specification   参数：parameter')->after('goods_attr_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        RC_Schema::table('goodslib_attr', function (Blueprint $table) {
            $table->dropColumn('cat_type');
        });
    }
}
