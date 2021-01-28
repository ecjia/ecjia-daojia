<?php

use Royalcms\Component\Database\Schema\Blueprint;
use Royalcms\Component\Database\Migrations\Migration;

class ChangeProcessTypeToStoreAccountOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (! RC_Schema::hasTable('store_account_order')) {
            return ;
        }

        //修改字段
        RC_Schema::table('store_account_order', function (Blueprint $table) {
            $table->string('process_type', 20)->comment('deposit充值，withdraw提现，bill结算，order购买，refund退款')->change();
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
