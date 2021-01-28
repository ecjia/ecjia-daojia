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

class CreateBonusTypeTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        if (RC_Schema::hasTable('bonus_type')) {
            return ;
        }

		RC_Schema::create('bonus_type', function(Blueprint $table)
		{
			$table->increments('type_id')->comment('红包类型流水号');
            $table->integer('store_id')->unsigned()->default('0')->index('store_id')->comment('店铺ID');
            $table->string('type_name', 60)->comment('红包名称');
            $table->decimal('type_money', 10, 2)->unsigned()->default('0.00')->comment('红包所值的金额');
            $table->tinyInteger('send_type')->unsigned()->default('0')->comment('红包发送类型0按用户如会员等级,会员名称发放;1按商品类别发送;2按订单金额所达到的额度发送;3线下发送');
            $table->tinyInteger('usebonus_type')->unsigned()->default('0')->comment('红包类型0店铺；1全场');
            $table->decimal('min_amount', 10, 2)->unsigned()->default('0.00')->comment('如果按金额发送红包,该项是最小金额,即只要购买超过该金额的商品都可以领到红包');
            $table->decimal('max_amount', 10, 2)->unsigned()->default('0.00')->comment('如果按金额发送红包,该项是最大金额,即只要购买超低于该金额的商品都可以领到红包');
            $table->integer('send_start_date')->unsigned()->default('0')->comment('红包发送的开始时间');
            $table->integer('send_end_date')->unsigned()->default('0')->comment('红包可以使用的开始时间');
            $table->integer('use_start_date')->unsigned()->default('0');
            $table->integer('use_end_date')->unsigned()->default('0')->comment('红包可以使用的结束时间');
            $table->decimal('min_goods_amount', 10, 2)->unsigned()->default('0.00')->comment('可以使用该红包的商品的最低价格,即只要达到该价格商品才可以使用红包');
            
            $table->unique(array('type_id', 'store_id'), 'store_bonus_type');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		RC_Schema::drop('bonus_type');
	}

}
