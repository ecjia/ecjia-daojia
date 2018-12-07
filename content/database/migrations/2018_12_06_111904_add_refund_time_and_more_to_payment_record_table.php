<?php

use Royalcms\Component\Database\Schema\Blueprint;
use Royalcms\Component\Database\Migrations\Migration;

class AddRefundTimeAndMoreToPaymentRecordTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        RC_Schema::table('payment_record', function (Blueprint $table) {
            $table->integer('refund_time')->unsigned()->default('0')->comment('退款时间')->after('last_error_time');
            $table->decimal('refund_amount', 10, 2)->unsigned()->default('0.00')->comment('退款金额')->after('refund_time');
            $table->string('refund_operator', 100)->nullable()->comment('退款操作员')->after('refund_amount');
            $table->string('refund_request_no', 60)->nullable()->comment('退款序列号')->after('refund_operator');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        RC_Schema::table('payment_record', function (Blueprint $table) {
            $table->dropColumn('refund_time');
            $table->dropColumn('refund_amount');
            $table->dropColumn('refund_operator');
            $table->dropColumn('refund_request_no');
        });
    }
}
