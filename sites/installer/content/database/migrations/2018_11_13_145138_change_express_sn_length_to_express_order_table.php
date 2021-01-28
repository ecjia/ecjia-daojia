<?php

use Royalcms\Component\Database\Schema\Blueprint;
use Royalcms\Component\Database\Migrations\Migration;

class ChangeExpressSnLengthToExpressOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (! RC_Schema::hasTable('express_order')) {
            return ;
        }

        //修改字段
        RC_Schema::table('express_order', function (Blueprint $table) {
            $table->string('express_sn', 60)->change();
            $table->string('order_sn', 60)->change();
            $table->string('delivery_sn', 60)->change();
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
