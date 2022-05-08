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
        if (RC_Schema::hasTable('separate_order_info')) {
            return ;
        }

        RC_Schema::create('separate_order_info', function (Blueprint $table) {
            $table->increments('order_id')->comment('订单ID');
            $table->string('order_sn', 60)->comment('订单SN,11开头');
            $table->mediumInteger('user_id')->unsigned()->default('0')->comment('用户ID');
            $table->tinyInteger('order_status')->unsigned()->default('0')->comment('订单状态');
            $table->tinyInteger('pay_status')->unsigned()->default('0')->comment('支付状态');
            $table->tinyInteger('pay_id')->default('0')->comment('支付ID');
            $table->string('pay_name', 120)->nullable()->comment('支付方式名称');
            $table->text('shippings')->nullable()->comment('配送信息序列化');
            $table->string('how_oos', 120)->nullable()->comment('无库存怎么做');
            $table->string('how_surplus', 120)->nullable()->comment('存货过多怎么做');
            $table->string('inv_type', 60)->nullable()->comment('发票类型');
            $table->string('inv_payee', 120)->nullable()->comment('抬头');
            $table->string('inv_no', 60)->nullable()->comment('税号');
            $table->string('inv_content', 120)->nullable()->comment('发票内容');
            $table->decimal('goods_amount', 10, 2)->default('0.00')->comment('产品总额');
            $table->decimal('shipping_fee', 10, 2)->default('0.00')->comment('运费');
            $table->decimal('insure_fee', 10, 2)->default('0.00')->comment('保价费');
            $table->decimal('pay_fee', 10, 2)->default('0.00')->comment('支付费率');
            $table->decimal('money_paid', 10, 2)->default('0.00')->comment('实付金额');
            $table->decimal('surplus', 10, 2)->default('0.00')->comment('使用余额支付金额');
            $table->integer('integral')->unsigned()->default('0')->comment('积分');
            $table->decimal('integral_money', 10, 2)->default('0.00')->comment('使用积分支付的金额');
            $table->decimal('bonus', 10, 2)->default('0.00')->comment('红包');
            $table->decimal('order_amount', 10, 2)->default('0.00')->comment('订单总额');
            $table->mediumInteger('bonus_id')->unsigned()->default('0')->comment('红包 ID');
            $table->decimal('tax', 10, 2)->default('0.00')->comment('税');
            $table->decimal('discount', 10, 2)->default('0.00')->comment('折扣');
            $table->integer('add_time')->unsigned()->default('0')->comment('添加时间');
            $table->integer('confirm_time')->unsigned()->default('0')->comment('确认时间');
            $table->integer('pay_time')->unsigned()->default('0')->comment('支付时间');
            $table->string('postscript', 255)->nullable()->comment('备注');
            $table->string('consignee', 60)->nullable()->comment('收货人');
            $table->string('country', 20)->nullable()->comment('收货地址国家');
            $table->string('province', 20)->nullable()->comment('收货地址省份');
            $table->string('city', 20)->nullable()->comment('收货地址城市');
            $table->string('district', 20)->nullable()->comment('收货地址区');
            $table->string('street', 20)->nullable()->comment('收货地街道');
            $table->string('address', 255)->nullable()->comment('收货详细地址');
            $table->string('longitude', 20)->nullable()->comment('经度');
            $table->string('latitude', 20)->nullable()->comment('纬度');
            $table->string('zipcode', 60)->nullable()->comment('邮编');
            $table->string('tel', 60)->nullable()->comment('电话');
            $table->string('mobile', 60)->nullable()->comment('手机');
            $table->string('email', 60)->nullable()->comment('邮箱');
            $table->smallInteger('from_ad')->default('0')->comment('格式化广告');
            $table->string('referer', 255)->nullable()->comment('referer信息');
            $table->string('extension_code', 60)->nullable()->comment('分机号码');
            $table->mediumInteger('extension_id')->unsigned()->default('0')->comment('延期id');
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
