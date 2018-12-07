<?php

use Royalcms\Component\Database\Schema\Blueprint;
use Royalcms\Component\Database\Migrations\Migration;

class AddPayFeeAndMoreToUserAccountTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        RC_Schema::table('user_account', function (Blueprint $table) {
            $table->decimal('pay_fee', 10, 2)->default('0.00')->comment('提现手续费')->after('amount');
            $table->decimal('real_amount', 10, 2)->default('0.00')->comment('真实到帐金额')->after('pay_fee');
            $table->integer('review_time')->unsigned()->default('0')->comment('审核时间')->after('real_amount');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        RC_Schema::table('user_account', function (Blueprint $table) {
            $table->dropColumn('pay_fee');
            $table->dropColumn('real_amount');
            $table->dropColumn('review_time');
        });
    }
}
