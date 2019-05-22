<?php

use Royalcms\Component\Database\Schema\Blueprint;
use Royalcms\Component\Database\Migrations\Migration;

class AddCatTypeToGoodsTypeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        RC_Schema::table('goods_type', function (Blueprint $table) {
            $table->string('cat_type', 60)->nullable()->comment('规格：specification   参数：parameter')->after('cat_name');

            $table->dropUnique('store_cat');
        });

        RC_Schema::table('goods_type', function (Blueprint $table) {
            $table->unique(['store_id', 'cat_name', 'cat_type'], 'store_cat');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        RC_Schema::table('goods_type', function (Blueprint $table) {
            $table->dropColumn('cat_type');

            $table->dropUnique('store_cat');
        });

        RC_Schema::table('goods_type', function (Blueprint $table) {
            $table->unique(['store_id', 'cat_name'], 'store_cat');
        });
    }
}
