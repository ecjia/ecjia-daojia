<?php

use Royalcms\Component\Database\Schema\Blueprint;
use Royalcms\Component\Database\Migrations\Migration;

class AddColumnBuyTimesAndBuyAmountToStoreUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (! RC_Schema::hasTable('store_users')) {
            return ;
        }

        //添加字段
        RC_Schema::table('store_users', function (Blueprint $table) {
            if (!RC_Schema::hasColumn('store_users', 'buy_times')) $table->integer('buy_times')->unsigned()->default('0')->comment('消费次数')->after('last_buy_time');
            if (!RC_Schema::hasColumn('store_users', 'buy_amount')) $table->decimal('buy_amount', 10, 2)->default('0.00')->comment('消费金额')->after('buy_times');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //删除字段
        RC_Schema::table('store_users', function (Blueprint $table) {
            $table->dropColumn('buy_times');
            $table->dropColumn('buy_amount');
        });

    }
}
