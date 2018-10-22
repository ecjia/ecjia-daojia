<?php

use Royalcms\Component\Database\Schema\Blueprint;
use Royalcms\Component\Database\Migrations\Migration;

class CreateCashierPendorderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        RC_Schema::create('cashier_pendorder', function (Blueprint $table) {
            $table->increments('pendorder_id');
            $table->integer('store_id')->unsigned()->default('0')->comment('店铺id');
            $table->string('pendorder_sn', 60)->comment('挂单编号');
            $table->integer('pendorder_time')->unsigned()->default('0')->comment('挂单时间');
            $table->integer('cashier_user_id')->unsigned()->default('0')->comment('收银员id同adviser表id');
            $table->string('cashier_user_type', 60)->default('merchant')->comment('挂单收银员类型（admin平台收银员，merchant商家收银员）');

            $table->index('store_id', 'store_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        RC_Schema::drop('cashier_pendorder');
    }
}
