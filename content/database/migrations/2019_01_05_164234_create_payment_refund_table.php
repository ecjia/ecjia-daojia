<?php

use Royalcms\Component\Database\Schema\Blueprint;
use Royalcms\Component\Database\Migrations\Migration;

class CreatePaymentRefundTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        RC_Schema::create('payment_refund', function (Blueprint $table) {
            $table->increments('id');
            $table->string('refund_out_no', 60)->comment('订单退款流水号');
            $table->string('refund_trade_no', 60)->nullable()->comment('支付公司退款流水号');
            $table->decimal('refund_fee', 10, 2)->default('0.00')->comment('退款金额');
            $table->tinyInteger('refund_status')->default('0');
            $table->integer('refund_create_time')->unsigned()->default('0')->comment('退款创建时间');
            $table->integer('refund_confirm_time')->unsigned()->default('0')->comment('退款确认时间');
            $table->text('refund_info')->nullable()->comment('退款信息（序列化存储）');
            $table->string('order_sn', 60)->comment('订单编号');
            $table->string('order_type', 60)->nullable()->comment('订单类型');
            $table->string('order_trade_no', 60)->nullable()->comment('订单支付流水号');
            $table->decimal('order_total_fee', 10, 2)->default('0.00')->comment('订单金额');
            $table->string('pay_trade_no', 60)->comment('支付公司流水号');
            $table->string('pay_code', 60)->comment('支付方式');
            $table->string('pay_name', 60)->nullable()->comment('支付方式名称');
            $table->string('last_error_message', 255)->nullable()->comment('最后一条错误信息');
            $table->integer('last_error_time')->nullable()->comment('最后一条错误时间');

            $table->index('refund_out_no', 'refund_out_no');
            $table->index('refund_trade_no', 'refund_trade_no');
            $table->index('order_trade_no', 'order_trade_no');
            $table->index('pay_trade_no', 'pay_trade_no');
            $table->index('order_sn', 'order_sn');
            $table->index('refund_status', 'refund_status');
            $table->index('pay_code', 'pay_code');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        RC_Schema::drop('payment_refund');
    }
}
