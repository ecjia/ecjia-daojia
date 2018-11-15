<?php

use Royalcms\Component\Database\Schema\Blueprint;
use Royalcms\Component\Database\Migrations\Migration;

class CreateMerchantMenuTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        RC_Schema::create('merchant_menu', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('store_id')->unsigned()->default('0')->comment('店铺ID');
            $table->integer('pid')->unsigned()->default('0')->comment('父级ID');
            $table->string('name', 50)->comment('菜单名称');
            $table->string('url', 255)->nullable()->comment('网页链接，view类型必须');
            $table->tinyInteger('sort')->unsigned()->default('0')->comment('排序');
            $table->tinyInteger('status')->unsigned()->default('0')->comment('状态');

            $table->index('store_id', 'store_id');
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
        RC_Schema::drop('merchant_menu');
    }
}
