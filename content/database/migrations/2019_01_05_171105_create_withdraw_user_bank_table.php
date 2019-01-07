<?php

use Royalcms\Component\Database\Schema\Blueprint;
use Royalcms\Component\Database\Migrations\Migration;

class CreateWithdrawUserBankTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        RC_Schema::create('withdraw_user_bank', function (Blueprint $table) {
            $table->increments('id');
            $table->string('bank_name', 60)->nullable()->comment('银行名称');
            $table->string('bank_card', 60)->comment('银行卡号');
            $table->string('bank_branch_name', 60)->nullable()->comment('开户行既开户银行支行名称');
            $table->string('cardholder', 60)->comment('持卡人');
            $table->string('bank_en_short', 60)->comment('银行英文简称（ICBC中国工商银行，CCB中国建设银行，ABC中国农业银行等）');
            $table->integer('user_id')->default('0')->comment('用户id，同users表user_id；配送员id同staff_user表user_id');
            $table->string('user_type', 60)->nullable()->comment('用户类型（user普通会员，express配送员）');
            $table->string('bank_type', 60)->nullable()->comment('绑定卡类型（bank银行卡，wechat微信钱包）');
            $table->integer('add_time')->unsigned()->default('0')->comment('绑定时间');
            $table->integer('update_time')->unsigned()->default('0')->comment('更新时间');

            $table->index(['user_id', 'user_type', 'bank_type'], 'user_bank_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        RC_Schema::drop('withdraw_user_bank');
    }
}
