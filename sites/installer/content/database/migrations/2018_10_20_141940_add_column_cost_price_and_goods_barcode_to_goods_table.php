<?php

use Royalcms\Component\Database\Schema\Blueprint;
use Royalcms\Component\Database\Migrations\Migration;

class AddColumnCostPriceAndGoodsBarcodeToGoodsTable extends Migration
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
            if (!RC_Schema::hasColumn('goods', 'goods_barcode')) $table->string('goods_barcode', 60)->nullable()->comment('商品条形码')->after('goods_sn');
            if (!RC_Schema::hasColumn('goods', 'cost_price')) $table->decimal('cost_price', 10, 2)->unsigned()->default('0.00')->comment('商品进货价')->after('shop_price');
            if (!RC_Schema::hasColumn('goods', 'generate_date')) $table->date('generate_date')->nullable()->comment('生产日期')->after('cost_price');
            if (!RC_Schema::hasColumn('goods', 'expiry_date')) $table->date('expiry_date')->nullable()->comment('到期日期')->after('generate_date');
            if (!RC_Schema::hasColumn('goods', 'limit_days')) $table->string('limit_days', 60)->nullable()->comment('保质期（如：2 day， 2 month，2 year）')->after('expiry_date');
            if (!RC_Schema::hasColumn('goods', 'weight_unit')) $table->tinyInteger('weight_unit')->default('0')->comment('商品重量单位：1克，2千克')->after('goods_weight');
            if (!RC_Schema::hasColumn('goods', 'weight_stock')) $table->decimal('weight_stock', 10, 3)->default('0.000')->comment('散装商品库存重量')->after('goods_number');
            if (!RC_Schema::hasColumn('goods', 'goods_buy_weight')) $table->decimal('goods_buy_weight', 10, 3)->default('0.000')->comment('散装商品购买总重量')->after('weight_stock');
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
            $table->dropColumn('goods_barcode');
            $table->dropColumn('cost_price');
            $table->dropColumn('generate_date');
            $table->dropColumn('expiry_date');
            $table->dropColumn('limit_days');
            $table->dropColumn('weight_unit');
            $table->dropColumn('weight_stock');
            $table->dropColumn('goods_buy_weight');
        });
    }
}
