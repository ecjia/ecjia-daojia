<?php

use Royalcms\Component\Database\Schema\Blueprint;
use Royalcms\Component\Database\Migrations\Migration;

class CreateMerchantNewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        RC_Schema::create('merchant_news', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('store_id')->unsigned()->default('0')->comment('店铺ID');
            $table->integer('group_id')->unsigned()->default('0');
            $table->string('title', 100)->comment('标题');
            $table->string('description', 255)->nullable()->comment('描述');
            $table->string('image', 100)->nullable()->comment('图片地址');
            $table->string('content_url', 100)->nullable()->comment('详情跳转链接');
            $table->string('type', 30)->nullable();
            $table->tinyInteger('status')->default('0')->comment('0未发送 1已发送');
            $table->text('content')->nullable()->comment('图文消息页面的内容，支持HTML标签');
            $table->tinyInteger('sort')->unsigned()->default('0');
            $table->integer('click_count')->unsigned()->default('0')->comment('浏览数');
            $table->integer('create_time')->unsigned()->default('0');
            $table->integer('send_time')->unsigned()->default('0');

            $table->index('store_id', 'store_id');
            $table->index('group_id', 'group_id');
            $table->index('status', 'status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        RC_Schema::drop('merchant_news');
    }
}
