<?php

use Royalcms\Component\Database\Schema\Blueprint;
use Royalcms\Component\Database\Migrations\Migration;

class CreateCashierScalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (RC_Schema::hasTable('cashier_scales')) {
            return ;
        }

        RC_Schema::create('cashier_scales', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('store_id')->unsigned()->default('0')->comment('店铺id');
            $table->tinyInteger('scale_sn')->unsigned()->comment('电子秤编码既电子秤条码标识位（通常有21，22，24，29等）');
            $table->tinyInteger('barcode_mode')->default('1')->comment('电子秤条码模式（1：金额模式，2：重量模式，3： 重量模式+金额模式）');
            $table->tinyInteger('date_format')->default('1')->comment('日期格式（1：yyyy-mm-dd格式，2：yyyy.mm.dd格式）');
            $table->tinyInteger('weight_unit')->default('1')->comment('净重单位（1：克，2：千克）');
            $table->tinyInteger('price_unit')->default('1')->comment('单价单位（1：克/元，2：千克/元）');
            $table->tinyInteger('wipezero')->default('0')->comment('是否抹零既取整（0：否，1：是）');
            $table->tinyInteger('reserve_quantile')->default('0')->comment('是否保留分位（0：否，1：是）');

            $table->unique(['store_id', 'scale_sn'], 'store_scale');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        RC_Schema::drop('cashier_scales');
    }
}
