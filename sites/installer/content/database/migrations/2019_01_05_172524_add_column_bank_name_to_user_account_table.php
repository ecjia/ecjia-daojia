<?php

use Royalcms\Component\Database\Schema\Blueprint;
use Royalcms\Component\Database\Migrations\Migration;

class AddColumnBankNameToUserAccountTable extends Migration
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
            if (!RC_Schema::hasColumn('user_account', 'bank_name')) $table->string('bank_name', 60)->nullable()->comment('银行名称')->after('is_paid');
            if (!RC_Schema::hasColumn('user_account', 'bank_branch_name')) $table->string('bank_branch_name', 60)->nullable()->comment('开户银行支行名称')->after('bank_name');
            if (!RC_Schema::hasColumn('user_account', 'bank_card')) $table->string('bank_card', 60)->nullable()->comment('银行卡号')->after('bank_branch_name');
            if (!RC_Schema::hasColumn('user_account', 'cardholder')) $table->string('cardholder', 60)->nullable()->comment('持卡人')->after('bank_card');
            if (!RC_Schema::hasColumn('user_account', 'bank_en_short')) $table->string('bank_en_short', 60)->nullable()->comment('银行英文简称（ICBC中国工商银行等）')->after('cardholder');
            if (!RC_Schema::hasColumn('user_account', 'payment_name')) $table->string('payment_name', 60)->nullable()->comment('支付方式名称或提现方式名称')->after('payment');
        });

        //修改字段
        RC_Schema::table('user_account', function(Blueprint $table)
        {
            $table->string('payment', 60)->nullable()->comment('支付方式代号或提现方式代号')->change();
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
            $table->dropColumn('bank_name');
            $table->dropColumn('bank_branch_name');
            $table->dropColumn('bank_card');
            $table->dropColumn('cardholder');
            $table->dropColumn('bank_en_short');
            $table->dropColumn('payment_name');
        });
    }
}
