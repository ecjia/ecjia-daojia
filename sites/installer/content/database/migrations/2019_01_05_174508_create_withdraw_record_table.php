<?php

use Royalcms\Component\Database\Schema\Blueprint;
use Royalcms\Component\Database\Migrations\Migration;

class CreateWithdrawRecordTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (RC_Schema::hasTable('withdraw_record')) {
            return ;
        }

        RC_Schema::create('withdraw_record', function (Blueprint $table) {
            $table->increments('id');
            $table->string('order_sn', 60)->comment('订单编号');
            $table->string('trade_no', 60)->nullable()->comment('支付公司单号');
            $table->string('withdraw_code', 60)->nullable()->comment('提现方式');
            $table->string('withdraw_name', 60)->nullable()->comment('提现名称');
            $table->decimal('withdraw_amount', 10, 2)->unsigned()->default('0.00')->comment('提现金额');
            $table->tinyInteger('withdraw_status')->default('0')->comment('提现状态');
            $table->integer('create_time')->unsigned()->default('0')->comment('创建时间');
            $table->string('transfer_bank_no', 60)->nullable()->comment('银行卡号');
            $table->string('transfer_bank_code', 60)->nullable()->comment('收款方开户行');
            $table->string('transfer_true_name', 60)->nullable()->comment('用户真实姓名');
            $table->integer('transfer_time')->unsigned()->default('0')->comment('转账时间');
            $table->integer('payment_time')->unsigned()->default('0')->comment('付款成功时间');
            $table->string('partner_id', 60)->nullable()->comment('商户号');
            $table->string('account', 60)->nullable()->comment('收款帐号');
            $table->text('success_result')->nullable()->comment('接口请求结果，序列化存储');
            $table->string('last_error_message', 255)->nullable()->comment('最后一条错误信息');
            $table->integer('last_error_time')->nullable()->comment('最后一条错误时间');

            $table->index('withdraw_code', 'withdraw_code');
            $table->index('trade_no', 'trade_no');
            $table->index('order_sn', 'order_sn');
            $table->index('withdraw_status', 'withdraw_status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        RC_Schema::drop('withdraw_record');
    }
}
