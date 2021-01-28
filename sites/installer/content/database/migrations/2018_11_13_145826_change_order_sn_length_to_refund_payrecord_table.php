<?php

use Royalcms\Component\Database\Schema\Blueprint;
use Royalcms\Component\Database\Migrations\Migration;

class ChangeOrderSnLengthToRefundPayrecordTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (! RC_Schema::hasTable('refund_payrecord')) {
            return ;
        }

        //修改字段
        RC_Schema::table('refund_payrecord', function (Blueprint $table) {
            $table->string('order_sn', 60)->change();
            $table->string('refund_sn', 60)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

    }
}
