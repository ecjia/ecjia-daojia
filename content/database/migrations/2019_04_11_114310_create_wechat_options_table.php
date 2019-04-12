<?php

use Royalcms\Component\Database\Schema\Blueprint;
use Royalcms\Component\Database\Migrations\Migration;

class CreateWechatOptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        RC_Schema::create('wechat_options', function (Blueprint $table) {
            $table->increments('option_id');
            $table->integer('wechat_id')->unsigned()->default('0')->comment('默认0，公众号id');
            $table->string('option_name', 120)->comment('选项名称');
            $table->string('option_type', 60)->nullable()->comment('值类型，用于解析数据');
            $table->text('option_value')->nullable()->comment('选项值');

            $table->unique(array('wechat_id', 'option_name'), 'wechat_option');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        RC_Schema::drop('wechat_options');
    }
}
