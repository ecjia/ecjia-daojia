<?php

use Royalcms\Component\Database\Schema\Blueprint;
use Royalcms\Component\Database\Migrations\Migration;

class ChangeOrderSnLengthToDeliveryOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (! RC_Schema::hasTable('delivery_order')) {
            return ;
        }

        //修改字段
        RC_Schema::table('delivery_order', function (Blueprint $table) {
            $table->string('delivery_sn', 60)->change();
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

    }
}
