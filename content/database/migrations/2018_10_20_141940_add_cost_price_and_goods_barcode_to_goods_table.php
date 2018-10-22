<?php

use Royalcms\Component\Database\Schema\Blueprint;
use Royalcms\Component\Database\Migrations\Migration;

class AddCostPriceAndGoodsBarcodeToGoodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        RC_Schema::table('goods', function (Blueprint $table) {
            $table->string('goods_barcode', 60)->nullable()->comment('商品条形码')->after('goods_sn');
            $table->decimal('cost_price', 10, 2)->unsigned()->default('0.00')->comment('商品进货价')->after('shop_price');
            $table->date('generate_date')->nullable()->comment('生产日期')->after('cost_price');
            $table->date('expiry_date')->nullable()->comment('到期日期')->after('generate_date');
            $table->string('limit_days', 60)->nullable()->comment('保质期（如：2 day， 2 month，2 year）')->after('expiry_date');
            $table->tinyInteger('weight_unit')->default('0')->comment('商品重量单位：1克，2千克')->after('goods_weight');
            $table->decimal('weight_stock', 10, 3)->default('0.000')->comment('散装商品库存重量')->after('goods_number');
            $table->decimal('goods_buy_weight', 10, 3)->default('0.000')->comment('散装商品购买总重量')->after('weight_stock');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
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
