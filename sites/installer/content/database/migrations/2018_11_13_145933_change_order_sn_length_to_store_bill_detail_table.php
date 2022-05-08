<?php

use Royalcms\Component\Database\Schema\Blueprint;
use Royalcms\Component\Database\Migrations\Migration;

class ChangeOrderSnLengthToStoreBillDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (! RC_Schema::hasTable('store_bill_detail')) {
            return ;
        }

        //修改字段
        RC_Schema::table('store_bill_detail', function (Blueprint $table) {
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
