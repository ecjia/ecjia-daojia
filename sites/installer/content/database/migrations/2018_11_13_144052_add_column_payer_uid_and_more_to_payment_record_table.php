<?php

use Royalcms\Component\Database\Schema\Blueprint;
use Royalcms\Component\Database\Migrations\Migration;

class AddColumnPayerUidAndMoreToPaymentRecordTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (! RC_Schema::hasTable('payment_record')) {
            return ;
        }

        //添加字段
        RC_Schema::table('payment_record', function (Blueprint $table) {
            if (!RC_Schema::hasColumn('payment_record', 'payer_uid')) $table->string('payer_uid', 100)->nullable()->comment('付款人ID')->after('account');
            if (!RC_Schema::hasColumn('payment_record', 'payer_login')) $table->string('payer_login', 100)->nullable()->comment('付款人账号')->after('payer_uid');
            if (!RC_Schema::hasColumn('payment_record', 'subject')) $table->string('subject', 255)->nullable()->comment('交易概述')->after('payer_login');
            if (!RC_Schema::hasColumn('payment_record', 'operator')) $table->string('operator', 100)->nullable()->comment('操作员')->after('subject');
            if (!RC_Schema::hasColumn('payment_record', 'channel_payway')) $table->string('channel_payway', 60)->nullable()->comment('支付方式')->after('operator');
            if (!RC_Schema::hasColumn('payment_record', 'channel_payway_name')) $table->string('channel_payway_name', 60)->nullable()->comment('支付方式名称')->after('channel_payway');
            if (!RC_Schema::hasColumn('payment_record', 'channel_sub_payway')) $table->string('channel_sub_payway', 60)->nullable()->comment('二级支付方式')->after('channel_payway_name');
            if (!RC_Schema::hasColumn('payment_record', 'channel_trade_no')) $table->string('channel_trade_no', 60)->nullable()->comment('支付服务商订单')->after('channel_sub_payway');
            if (!RC_Schema::hasColumn('payment_record', 'channel_payment_list')) $table->string('channel_payment_list', 255)->nullable()->comment('活动优惠')->after('channel_trade_no');
            if (!RC_Schema::hasColumn('payment_record', 'last_error_message')) $table->string('last_error_message', 255)->nullable()->comment('最后一次错误信息')->after('channel_payment_list');
            if (!RC_Schema::hasColumn('payment_record', 'last_error_time')) $table->integer('last_error_time')->unsigned()->nullable()->comment('最后一次错误时间')->after('last_error_message');
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
        RC_Schema::table('payment_record', function (Blueprint $table) {
            $table->dropColumn('payer_uid');
            $table->dropColumn('payer_login');
            $table->dropColumn('subject');
            $table->dropColumn('operator');
            $table->dropColumn('channel_payway');
            $table->dropColumn('channel_payway_name');
            $table->dropColumn('channel_sub_payway');
            $table->dropColumn('channel_trade_no');
            $table->dropColumn('channel_payment_list');
            $table->dropColumn('last_error_message');
            $table->dropColumn('last_error_time');
        });
    }
}
