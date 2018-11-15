<?php

use Royalcms\Component\Database\Schema\Blueprint;
use Royalcms\Component\Database\Migrations\Migration;

class AlterOrderSnLengthToStoreBillDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
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
        RC_Schema::table('store_bill_detail', function (Blueprint $table) {
            //
        });
    }
}
