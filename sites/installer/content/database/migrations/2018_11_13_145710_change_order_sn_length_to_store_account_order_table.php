<?php

use Royalcms\Component\Database\Schema\Blueprint;
use Royalcms\Component\Database\Migrations\Migration;

class ChangeOrderSnLengthToStoreAccountOrderTable extends Migration
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
            $table->string('order_sn', 60)->change();
            $table->string('bill_order_sn', 60)->change();
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
