<?php

use Royalcms\Component\Database\Schema\Blueprint;
use Royalcms\Component\Database\Migrations\Migration;

class AlterUserIdToMarketActivityLotteryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //修改字段
        RC_Schema::table('market_activity_lottery', function(Blueprint $table)
        {
            $table->string('user_id', 60)->nullable()->default('')->comment('根据user_type存放wechat_user表openid或users表user_id')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //修改字段
        RC_Schema::table('market_activity_lottery', function(Blueprint $table)
        {
            $table->integer('user_id')->unsigned()->default('0')->comment('会员id')->change();
        });
    }
}
