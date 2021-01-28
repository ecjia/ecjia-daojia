<?php

use Royalcms\Component\Database\Schema\Blueprint;
use Royalcms\Component\Database\Migrations\Migration;

class CreateWithdrawMethodTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (RC_Schema::hasTable('withdraw_method')) {
            return ;
        }

        RC_Schema::create('withdraw_method', function (Blueprint $table) {
            $table->increments('withdraw_id')->comment('提现方式ID');
            $table->string('withdraw_code', 60)->comment('提现方式code');
            $table->string('withdraw_name', 120);
            $table->string('withdraw_fee', 10)->default('0')->comment('提现手续费');
            $table->text('withdraw_desc')->nullable()->comment('提现描述');
            $table->integer('withdraw_order')->default('0')->comment('提现订单');
            $table->text('withdraw_config')->nullable()->comment('提现配置');
            $table->tinyInteger('enabled')->default('0')->comment('是否开启');
            $table->tinyInteger('is_online')->default('0')->comment('是否在线');

            $table->unique('withdraw_code', 'withdraw_code');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        RC_Schema::drop('withdraw_method');
    }
}
