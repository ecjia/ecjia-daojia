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

class CreateExpressOrderTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        if (RC_Schema::hasTable('express_order')) {
            return ;
        }

		RC_Schema::create('express_order', function(Blueprint $table)
		{
			$table->increments('express_id')->comment('自增id号');
            $table->string('express_sn', 20)->comment('流水号');
            $table->string('order_sn', 20)->index('order_sn')->comment('订单id号');
            $table->mediumInteger('order_id')->unsigned()->default('0')->index('order_id')->comment('发货单id号');
            $table->mediumInteger('delivery_id')->unsigned()->default('0')->index('delivery_id');
            $table->string('delivery_sn', 20)->index('delivery_sn')->comment('发货单流水');
            $table->integer('store_id')->unsigned()->default('0')->index('store_id')->comment('店铺id号');
            $table->mediumInteger('user_id')->unsigned()->default('0')->index('user_id')->comment('用户id号');
            $table->string('consignee', 60)->nullable()->comment('收货人');
            $table->string('address', 250)->nullable()->comment('收货地址');
            $table->smallInteger('country')->unsigned()->default('0')->comment('国家');
            $table->smallInteger('province')->unsigned()->default('0')->comment('省');
            $table->smallInteger('city')->unsigned()->default('0')->comment('城市');
            $table->smallInteger('district')->unsigned()->default('0')->comment('地区');
            $table->string('email', 60)->nullable()->comment('电子邮箱');
            $table->string('mobile', 60)->nullable()->comment('手机');
            $table->string('best_time', 120)->nullable()->comment('最佳配送时间');
            $table->string('remark', 120)->nullable()->comment('备注');
            $table->decimal('shipping_fee', 10, 2)->unsigned()->default('0.00')->comment('运费');
            $table->decimal('commision', 10, 2)->unsigned()->default('0.00')->comment('佣金');
            $table->integer('add_time')->unsigned()->default('0')->comment('添加时间');
            $table->integer('receive_time')->unsigned()->default('0')->comment('接单时间');
            $table->integer('express_time')->unsigned()->default('0')->comment('取货配送时间');
            $table->integer('signed_time')->unsigned()->default('0')->comment('签收时间');
            $table->integer('update_time')->unsigned()->default('0')->comment('更新时间');
            $table->string('longitude', 20)->nullable()->comment('经度');
            $table->string('latitude', 20)->nullable()->comment('纬度');
            $table->integer('distance')->unsigned()->default('0')->comment('距离');
            $table->string('from', 10)->nullable()->comment('来源：assign(派单)，grab(抢单)');
            $table->tinyInteger('status')->unsigned()->default('0')->comment('0未分配派单,1已接派单待取货,2已取货派送中,3退货中,4拒收,5已签收,6已退回');
            $table->integer('staff_id')->unsigned()->default('0')->comment('员工id号');
            $table->string('express_user', 20)->nullable()->comment('配送员名字');
            $table->string('express_mobile', 20)->nullable()->comment('配送员联系电话');
            $table->tinyInteger('comment_rank')->unsigned()->default('5')->comment('评分');
            $table->string('comment_content', 60)->nullable()->comment('自营配送订单信息表');
            
            $table->index(array('order_id', 'store_id'), 'store_order');
            $table->unique(array('express_id', 'store_id'), 'store_express_order');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		RC_Schema::drop('express_order');
	}

}
