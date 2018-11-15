<?php

use Royalcms\Component\Database\Schema\Blueprint;
use Royalcms\Component\Database\Migrations\Migration;

class AddBuyTimesAndBuyAmountToStoreUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        RC_Schema::table('store_users', function (Blueprint $table) {
            $table->renameColumn('jion_scene', 'join_scene');
            $table->renameColumn('jion_scene_str', 'join_scene_str');

            $table->integer('buy_times')->unsigned()->default('0')->comment('消费次数')->after('last_buy_time');
            $table->decimal('buy_amount', 10, 2)->default('0.00')->comment('消费金额')->after('buy_times');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        RC_Schema::table('store_users', function (Blueprint $table) {
            $table->renameColumn('join_scene', 'jion_scene');
            $table->renameColumn('join_scene_str', 'jion_scene_str');

            $table->dropColumn('buy_times');
            $table->dropColumn('buy_amount');
        });
    }
}
