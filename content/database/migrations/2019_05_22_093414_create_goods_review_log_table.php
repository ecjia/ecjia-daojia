<?php

use Royalcms\Component\Database\Schema\Blueprint;
use Royalcms\Component\Database\Migrations\Migration;

class CreateGoodsReviewLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        RC_Schema::create('goods_review_log', function (Blueprint $table) {
            $table->integer('action_id');
            $table->integer('goods_id')->unsigned()->default('0')->comment('审核商品id');
            $table->string('action_user_type', 60)->nullable()->comment('操作用户类型');
            $table->integer('action_user_id')->unsigned()->default('0')->comment('操作者用户id');
            $table->string('action_user_name', 60)->nullable()->comment('操作者用户名称');
            $table->tinyInteger('status')->default('0')->comment('审核状态 2拒绝 3通过');
            $table->string('action_note', 255)->nullable()->comment('操作备注');
            $table->integer('add_time')->unsigned()->default('0')->comment('操作时间');

            $table->index('goods_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        RC_Schema::drop('goods_review_log');
    }
}
