<?php
//
//    ______         ______           __         __         ______
//   /\  ___\       /\  ___\         /\_\       /\_\       /\  __ \
//   \/\  __\       \/\ \____        \/\_\      \/\_\      \/\ \_\ \
//    \/\_____\      \/\_____\     /\_\/\_\      \/\_\      \/\_\ \_\
//     \/_____/       \/_____/     \/__\/_/       \/_/       \/_/ /_/
//
//   上海商创网络科技有限公司
//
//  ---------------------------------------------------------------------------------
//
//   一、协议的许可和权利
//
//    1. 您可以在完全遵守本协议的基础上，将本软件应用于商业用途；
//    2. 您可以在协议规定的约束和限制范围内修改本产品源代码或界面风格以适应您的要求；
//    3. 您拥有使用本产品中的全部内容资料、商品信息及其他信息的所有权，并独立承担与其内容相关的
//       法律义务；
//    4. 获得商业授权之后，您可以将本软件应用于商业用途，自授权时刻起，在技术支持期限内拥有通过
//       指定的方式获得指定范围内的技术支持服务；
//
//   二、协议的约束和限制
//
//    1. 未获商业授权之前，禁止将本软件用于商业用途（包括但不限于企业法人经营的产品、经营性产品
//       以及以盈利为目的或实现盈利产品）；
//    2. 未获商业授权之前，禁止在本产品的整体或在任何部分基础上发展任何派生版本、修改版本或第三
//       方版本用于重新开发；
//    3. 如果您未能遵守本协议的条款，您的授权将被终止，所被许可的权利将被收回并承担相应法律责任；
//
//   三、有限担保和免责声明
//
//    1. 本软件及所附带的文件是作为不提供任何明确的或隐含的赔偿或担保的形式提供的；
//    2. 用户出于自愿而使用本软件，您必须了解使用本软件的风险，在尚未获得商业授权之前，我们不承
//       诺提供任何形式的技术支持、使用担保，也不承担任何因使用本软件而产生问题的相关责任；
//    3. 上海商创网络科技有限公司不对使用本产品构建的商城中的内容信息承担责任，但在不侵犯用户隐
//       私信息的前提下，保留以任何方式获取用户信息及商品信息的权利；
//
//   有关本产品最终用户授权协议、商业授权与技术服务的详细内容，均由上海商创网络科技有限公司独家
//   提供。上海商创网络科技有限公司拥有在不事先通知的情况下，修改授权协议的权力，修改后的协议对
//   改变之日起的新授权用户生效。电子文本形式的授权协议如同双方书面签署的协议一样，具有完全的和
//   等同的法律效力。您一旦开始修改、安装或使用本产品，即被视为完全理解并接受本协议的各项条款，
//   在享有上述条款授予的权力的同时，受到相关的约束和限制。协议许可范围以外的行为，将直接违反本
//   授权协议并构成侵权，我们有权随时终止授权，责令停止损害，并保留追究相关责任的权力。
//
//  ---------------------------------------------------------------------------------
//
use Royalcms\Component\Database\Schema\Blueprint;
use Royalcms\Component\Database\Migrations\Migration;

class CreateOrderInfoTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        if (RC_Schema::hasTable('order_info')) {
            return ;
        }

		RC_Schema::create('order_info', function(Blueprint $table)
		{
		    $table->increments('order_id')->comment('自增ID');
		    $table->integer('store_id')->unsigned()->default('0')->index('store_id')->comment('店铺ID');
		    $table->string('order_sn', 20)->unique('order_sn')->comment('订单号,唯一');
		    $table->mediumInteger('user_id')->unsigned()->default('0')->index('user_id')->comment('用户id,同users的user_id');
		    $table->tinyInteger('order_status')->unsigned()->default('0')->index('order_status')->comment('订单状态，作何操作0,未确认,1已确认;2已取消;3无效;4退货;5已分单;6部分分单');
		    $table->tinyInteger('shipping_status')->unsigned()->default('0')->index('shipping_status')->comment('商品配送情况;0未发货,1已发货,2已收货,3备货中,4已发货(部分商品),5发货中(处理分单),6已发货(部分商品)');
		    $table->tinyInteger('pay_status')->unsigned()->default('0')->index('pay_status')->comment('支付状态;0未付款;1付款中;2已付款');
		    $table->string('consignee', 60)->nullable()->comment('收货人的姓名,用户页面填写,默认取值表user_address');
		    $table->smallInteger('country')->unsigned()->default('0')->comment('收货人的国家,用户页面填写,默认取值于表user_address,其id对应的值在region');
		    $table->smallInteger('province')->unsigned()->default('0')->comment('收货人的省份,用户页面填写,默认取值于表user_address,其id对应的值在region');
		    $table->smallInteger('city')->unsigned()->default('0')->comment('收货人的城市,用户页面填写,默认取值于表user_address,其id对应的值在region');
		    $table->smallInteger('district')->unsigned()->default('0')->comment('收货人的地区,用户页面填写,默认取值于表user_address,其id对应的值在region');
		    $table->string('address', 255)->nullable()->comment('收货人的详细地址,用户页面填写,默认取值于表user_address');
		    $table->string('longitude', 20)->nullable()->comment('经度');
		    $table->string('latitude', 20)->nullable()->comment('纬度');
		    $table->string('zipcode', 60)->nullable()->comment('收货人的邮编,用户页面填写,默认取值于表user_address');
		    $table->string('tel', 60)->nullable()->comment('收货人的电话,用户页面填写,默认取值于表user_address');
		    $table->string('mobile', 60)->nullable()->comment('收货人的手机,用户页面填写,默认取值于表user_address');
		    $table->string('email', 60)->nullable()->comment('收货人的Email,用户页面填写,默认取值于表user_address');
		    $table->string('best_time', 120)->nullable()->comment('收货人的最佳送货时间,用户页面填写,默认取值于表user_addr');
		    $table->string('sign_building', 120)->nullable()->comment('送货人的地址的标志性建筑,用户页面填写,默认取值于表user_address');
		    $table->string('postscript', 255)->nullable()->comment('订单附言,由用户提交订单前填写');
		    $table->tinyInteger('shipping_id')->default('0')->index('shipping_id')->comment('用户选择的配送方式id,取值表shipping');
		    $table->string('shipping_name', 120)->nullable()->comment('用户选择的配送方式的名称,取值表shipping');
		    $table->string('expect_shipping_time', 50)->nullable()->comment('预期送货时间');
		    $table->tinyInteger('pay_id')->default('0')->index('pay_id')->comment('用户选择的支付方式的id,取值表payment');
		    $table->string('pay_name', 120)->nullable()->comment('用户选择的支付方式名称,取值表payment');
		    $table->string('how_oos', 120)->nullable()->comment('缺货处理方式,等待所有商品备齐后再发,取消订单;与店主协商');
		    $table->string('how_surplus', 120)->nullable()->comment('根据字段猜测应该是余额处理方式,程序未作这部分实现');
		    $table->string('pack_name', 120)->nullable()->comment('包装名称,取值表pack');
		    $table->string('card_name', 120)->nullable()->comment('贺卡的名称,取值card');
		    $table->string('card_message', 255)->nullable()->comment('贺卡内容,由用户提交');
		    $table->string('inv_payee', 120)->nullable()->comment('发票抬头,用户页面填写');
		    $table->string('inv_content', 120)->nullable()->comment('发票内容,用户页面选择,取值shop_config的code字段的值为invoice_content的value');
		    $table->decimal('goods_amount', 10, 2)->default('0.00')->comment('商品的总金额');
		    $table->decimal('shipping_fee', 10, 2)->default('0.00')->comment('配送费用');
		    $table->decimal('insure_fee', 10, 2)->default('0.00')->comment('保价费用');
		    $table->decimal('pay_fee', 10, 2)->default('0.00')->comment('支付费用,跟支付方式的配置相关,取值表payment');
		    $table->decimal('pack_fee', 10, 2)->default('0.00')->comment('包装费用,取值表pack');
		    $table->decimal('card_fee', 10, 2)->default('0.00')->comment('贺卡费用,取值card');
		    $table->decimal('money_paid', 10, 2)->default('0.00')->comment('已付款金额');
		    $table->decimal('surplus', 10, 2)->default('0.00')->comment('该订单使用金额的数量,取用户设定余额,用户可用余额,订单金额中最小者');
		    $table->integer('integral')->unsigned()->default('0')->comment('使用的积分的数量,取用户使用积分,商品可用积分,用户拥有积分中最小者');
		    $table->decimal('integral_money', 10, 2)->default('0.00')->comment('使用积分金额');
		    $table->decimal('bonus', 10, 2)->default('0.00')->comment('使用红包金额');
		    $table->decimal('order_amount', 10, 2)->default('0.00')->comment('应付款金额');
		    $table->smallInteger('from_ad')->default('0')->comment('订单由某广告带来的广告id,应该取值于ad');
		    $table->string('referer', 255)->nullable()->comment('订单的来源页面');
		    $table->integer('add_time')->unsigned()->default('0')->comment('订单生成时间');
		    $table->integer('confirm_time')->unsigned()->default('0')->comment('订单确认时间');
		    $table->integer('pay_time')->unsigned()->default('0')->comment('订单支付时间');
		    $table->integer('shipping_time')->unsigned()->default('0')->comment('订单配送时间');
		    $table->integer('auto_delivery_time')->unsigned()->default('0')->comment('订单自动确认收货时间（天数');
		    $table->tinyInteger('pack_id')->unsigned()->default('0')->comment('包装id,取值表pck');
		    $table->tinyInteger('card_id')->unsigned()->default('0')->comment('贺卡id,用户在页面选择,取值');
		    $table->mediumInteger('bonus_id')->unsigned()->default('0')->comment('红包id,user_bonus的bonus_id');
		    $table->string('invoice_no', 255)->nullable()->comment('发货时填写,可在订单查询查看');
		    $table->string('extension_code', 30)->nullable()->comment('通过活动购买的商品的代号,group_buy是团购;auction是拍卖;snatch夺宝奇兵;正常普通产品该处理为空');
		    $table->mediumInteger('extension_id')->unsigned()->default('0')->comment('通过活动购买的物品id,取值ecs_good_activity;如果是正常普通商品,该处为0');
		    $table->string('to_buyer', 255)->nullable()->comment('商家给客户的留言,当该字段值时可以在订单查询看到');
		    $table->string('pay_note', 255)->nullable()->comment('付款备注,在订单管理编辑修改');
		    $table->smallInteger('agency_id')->unsigned()->default('0')->index('agency_id')->comment('该笔订单被指派给的办事处的id,根据订单内容和办事处负责范围自动决定,也可以有管理员修改,取值于表agency');
		    $table->string('inv_type', 60)->nullable()->comment('发票类型,用户页面选择,取值shop_config的code字段的值invoice_type的value');
		    $table->decimal('tax', 10, 2)->default('0.00')->comment('发票税额');
		    $table->tinyInteger('is_separate')->default('0')->comment('0未分成或等待分成;1已分成;2取消分成');
		    $table->mediumInteger('parent_id')->unsigned()->default('0')->comment('能获得推荐分成的用户id，id取值于表ecs_users');
		    $table->decimal('discount', 10, 2)->default('0.00')->comment('折扣金额');
		    $table->tinyInteger('is_delete')->unsigned()->default('0')->comment('会操作删除订单状态（0为删除，1删除回收站，2会员订单列表不显示该订单信息）');
		    $table->dateTime('delete_time')->nullable()->comment('删除时间');
		    $table->tinyInteger('is_settlement')->default('0')->comment('暂未使用');
		    $table->integer('sign_time')->unsigned()->default('0')->comment('暂未使用');
		    
		    $table->unique(array('order_id', 'store_id'), 'store_order');
		    $table->index(array('extension_code', 'extension_id'), 'extension_code');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		RC_Schema::drop('order_info');
	}

}
