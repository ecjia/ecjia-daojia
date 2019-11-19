<?php

use Royalcms\Component\Database\Schema\Blueprint;
use Royalcms\Component\Database\Migrations\Migration;

class CreateAffiliateGradeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /**
         * 分销权益表
         */
        RC_Schema::create('affiliate_grade', function (Blueprint $table) {
            $table->increments('grade_id');
            $table->string('grade_name', 30)->comment('权益名称');
            $table->tinyInteger('user_rank')->unsigned()->default('0')->comment('会员等级');;
            $table->mediumInteger('goods_id')->unsigned()->default('0')->comment('指定商品id');
            $table->longText('user_card_intro')->nullable()->comment('会员卡介绍');
            $table->longText('grade_intro')->nullable()->comment('权益介绍');
            $table->tinyInteger('limit_days')->unsigned()->default('1')->comment('有效期限，默认1年，单位年');
            $table->smallInteger('sort_order')->default('10');
            $table->integer('add_time')->unsigned()->default('0');

            $table->index('goods_id', 'goods_id');
            $table->index('add_time', 'add_time');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        RC_Schema::drop('affiliate_grade');
    }
}
