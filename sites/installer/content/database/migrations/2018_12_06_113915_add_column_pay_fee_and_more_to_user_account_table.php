<?php

use Royalcms\Component\Database\Schema\Blueprint;
use Royalcms\Component\Database\Migrations\Migration;

class AddColumnPayFeeAndMoreToUserAccountTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (! RC_Schema::hasTable('user_account')) {
            return ;
        }

        //添加字段
        RC_Schema::table('user_account', function (Blueprint $table) {
            if (!RC_Schema::hasColumn('user_account', 'pay_fee')) $table->decimal('pay_fee', 10, 2)->default('0.00')->comment('提现手续费')->after('amount');
            if (!RC_Schema::hasColumn('user_account', 'real_amount')) $table->decimal('real_amount', 10, 2)->default('0.00')->comment('真实到帐金额')->after('pay_fee');
            if (!RC_Schema::hasColumn('user_account', 'review_time')) $table->integer('review_time')->unsigned()->default('0')->comment('审核时间')->after('real_amount');
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
        RC_Schema::table('user_account', function (Blueprint $table) {
            $table->dropColumn('pay_fee');
            $table->dropColumn('real_amount');
            $table->dropColumn('review_time');
        });
    }
}
