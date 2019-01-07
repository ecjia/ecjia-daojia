<?php

use Royalcms\Component\Database\Schema\Blueprint;
use Royalcms\Component\Database\Migrations\Migration;

class AddOrderSnToUserBonusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        RC_Schema::table('user_bonus', function (Blueprint $table) {
            $table->string('order_sn', 60)->nullable()->comment('订单号SN')->after('order_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        RC_Schema::table('user_bonus', function (Blueprint $table) {
            $table->dropColumn('order_sn');
        });
    }
}
