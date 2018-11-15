<?php

use Royalcms\Component\Database\Schema\Blueprint;
use Royalcms\Component\Database\Migrations\Migration;

class CreateTrackLogisticTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        RC_Schema::create('track_logistic', function (Blueprint $table) {
            $table->increments('track_id');
            $table->integer('order_id')->unsigned()->default('0')->comment('订单id，同order_info表order_id');
            $table->string('order_type', 60)->default('default')->comment('订单类型（default默认）');
            $table->string('company_code', 60)->nullable()->comment('快递公司code（zhongtong，yuantong，yunda，shunfeng，shentong）');
            $table->string('company_name', 120)->nullable()->comment('快递公司名（中通速递，圆通速递，韵达快运，顺丰，申通）');
            $table->tinyInteger('status')->default('0')->comment('0在途,1揽件，2疑难，3签收，4退签，5派件，6退回');
            $table->string('track_number', 30)->nullable()->comment('快递运单编号');
            $table->integer('add_time')->unsigned()->nullable();
            $table->integer('update_time')->unsigned()->nullable();
            $table->integer('sign_time')->unsigned()->nullable();

            $table->unique(['order_id', 'order_type', 'track_number'], 'order_type_tracknum');
            $table->index('company_code', 'company_code');
            $table->index('status', 'status');
            $table->index('track_number', 'track_number');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        RC_Schema::drop('track_logistic');
    }
}
