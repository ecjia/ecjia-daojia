<?php

use Royalcms\Component\Database\Schema\Blueprint;
use Royalcms\Component\Database\Migrations\Migration;

class AlterChangeTypeToStoreAccountLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        RC_Schema::table('store_account_log', function (Blueprint $table) {
            $table->string('change_type', 20)->comment('deposit充值，withdraw提现，bill结算，order购买，refund退款')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        RC_Schema::table('store_account_log', function (Blueprint $table) {
            //
        });
    }
}
