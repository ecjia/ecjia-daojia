<?php

use Royalcms\Component\Database\Schema\Blueprint;
use Royalcms\Component\Database\Migrations\Migration;

class CreateSeparateOrderInfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        RC_Schema::create('separate_order_info', function (Blueprint $table) {
            $table->increments('order_id');
            $table->string('order_sn', 60)->comment('订单SN,11开头');
            $table->mediumInteger('user_id')->unsigned()->default('0');
            $table->tinyInteger('order_status')->unsigned()->default('0');
            $table->tinyInteger('pay_status')->unsigned()->default('0');
            $table->tinyInteger('pay_id')->default('0');
            $table->string('pay_name', 120)->nullable();
            $table->text('shippings')->nullable()->comment('配送信息序列化');
            $table->string('how_oos', 120)->nullable();
            $table->string('how_surplus', 120)->nullable();
            $table->string('inv_type', 60)->nullable();
            $table->string('inv_payee', 120)->nullable()->comment('抬头');
            $table->string('inv_no', 60)->nullable()->comment('税号');
            $table->string('inv_content', 120)->nullable();
            $table->decimal('goods_amount', 10, 2)->default('0.00');
            $table->decimal('shipping_fee', 10, 2)->default('0.00')->comment('运费');
            $table->decimal('insure_fee', 10, 2)->default('0.00')->comment('保价费');
            $table->decimal('pay_fee', 10, 2)->default('0.00');
            $table->decimal('money_paid', 10, 2)->default('0.00');
            $table->decimal('surplus', 10, 2)->default('0.00');
            $table->integer('integral')->unsigned()->default('0');
            $table->decimal('integral_money', 10, 2)->default('0.00');
            $table->decimal('bonus', 10, 2)->default('0.00');
            $table->decimal('order_amount', 10, 2)->default('0.00');
            $table->mediumInteger('bonus_id')->unsigned()->default('0');
            $table->decimal('tax', 10, 2)->default('0.00');
            $table->decimal('discount', 10, 2)->default('0.00');
            $table->integer('add_time')->unsigned()->default('0');
            $table->integer('confirm_time')->unsigned()->default('0');
            $table->integer('pay_time')->unsigned()->default('0');
            $table->string('postscript', 255)->nullable();
            $table->string('consignee', 60)->nullable();
            $table->string('country', 20)->nullable();
            $table->string('province', 20)->nullable();
            $table->string('city', 20)->nullable();
            $table->string('district', 20)->nullable();
            $table->string('street', 20)->nullable();
            $table->string('address', 255)->nullable();
            $table->string('longitude', 20)->nullable()->comment('经度');
            $table->string('latitude', 20)->nullable()->comment('纬度');
            $table->string('zipcode', 60)->nullable();
            $table->string('tel', 60)->nullable();
            $table->string('mobile', 60)->nullable();
            $table->string('email', 60)->nullable();
            $table->smallInteger('from_ad')->default('0');
            $table->string('referer', 255)->nullable();
            $table->string('extension_code', 60)->nullable();
            $table->mediumInteger('extension_id')->unsigned()->default('0');
            $table->mediumText('separate_order_goods')->nullable()->comment('商品序列化');
            $table->tinyInteger('is_separate')->default('0')->comment('是否分单，0未分，1已分');
            $table->string('pay_note', 255)->nullable()->comment('付款备注');
            $table->integer('affiliate_user_id')->unsigned()->default('0')->comment('推荐人id');

            $table->unique('order_sn', 'order_sn');
            $table->index(array('extension_code', 'extension_id'), 'extension_code');
            $table->index('user_id', 'user_id');
            $table->index('order_status', 'order_status');
            $table->index('pay_status', 'pay_status');
            $table->index('pay_id', 'pay_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        RC_Schema::drop('separate_order_info');
    }
}
