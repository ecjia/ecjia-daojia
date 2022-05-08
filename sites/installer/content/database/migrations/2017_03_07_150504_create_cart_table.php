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

class CreateCartTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        if (RC_Schema::hasTable('cart')) {
            return ;
        }

		RC_Schema::create('cart', function(Blueprint $table)
		{
			$table->increments('rec_id')->comment('自增id号');
            $table->mediumInteger('user_id')->unsigned()->default('0')->comment('会员ID，取自表users的user_id');
            $table->integer('store_id')->unsigned()->default('0')->index('store_id');
            $table->string('session_id', 40)->nullable()->index('session_id')->comment('如果该用户退出,该Session_id对应的购物车中所有记录都将被删除');
            $table->mediumInteger('goods_id')->comment('商品的ID,取自表goods的goods_id');
            $table->string('goods_sn', 60)->comment('商品的货号,取自表goods的goods_sn');
            $table->string('product_id', 60)->nullable()->comment('产品编号');
            $table->string('group_id', 60)->nullable()->comment('组id');
            $table->string('goods_name', 120)->comment('商品名称,取自表goods的goods_name');
            $table->decimal('market_price', 10, 2)->unsigned()->default('0.00')->comment('商品的本店价,取自表市场价');
            $table->decimal('goods_price', 10, 2)->unsigned()->default('0.00')->comment('商品的本店价,取自表goods的shop_price');
            $table->smallInteger('goods_number')->unsigned()->default('1')->comment('商品的购买数量,在购物车时,实际库存不减少');
            $table->text('goods_attr')->nullable()->comment('商品的扩展属性,取自goods的extension_code');
            $table->tinyInteger('is_real')->unsigned()->default('0')->comment('取自ecs_goods的is_real');
            $table->string('extension_code', 30)->nullable()->default('')->comment('商品的扩展属性,取自goods的extension_code');
            $table->mediumInteger('parent_id')->unsigned()->default('0')->comment('该商品的父商品ID,没有该值为0,有的话那该商品就是该id的配件');
            $table->tinyInteger('rec_type')->unsigned()->default('0')->comment('购物车商品类型;0普通;1团够;2拍卖;3夺宝奇兵;11收银台');
            $table->tinyInteger('is_gift')->unsigned()->default('0')->comment('是否赠品,0否;其他,是参加优惠活动的id,取值于favourable_activity的act_id');
            $table->tinyInteger('is_shipping')->unsigned()->default('0')->comment('是否购买');
            $table->tinyInteger('can_handsel')->unsigned()->default('0')->comment('能否处理');
            $table->tinyInteger('model_attr')->unsigned()->default('0')->comment('商品属性模式（0-默认，1-仓库，2-地区）');
            $table->string('goods_attr_id', 60)->nullable()->comment('商品属性id，取自goods_attr表的goods_attr_id');
            $table->decimal('shopping_fee', 10, 2)->unsigned()->default('0.00')->comment('费用');
            $table->tinyInteger('is_checked')->unsigned()->default('1')->comment('选中状态，0未选中，1选中')->comment('选中状态，0未选中，1选中');
            $table->integer('add_time')->unsigned()->default('0')->comment('添加时间');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		RC_Schema::drop('cart');
	}

}
