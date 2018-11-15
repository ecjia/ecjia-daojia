<?php

use Royalcms\Component\Database\Schema\Blueprint;
use Royalcms\Component\Database\Migrations\Migration;

class AlterOrderSnLengthToRefundOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        RC_Schema::table('refund_order', function (Blueprint $table) {
            $table->string('refund_sn', 60)->change();
            $table->string('order_sn', 60)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        RC_Schema::table('refund_order', function (Blueprint $table) {
            //
        });
    }
}
