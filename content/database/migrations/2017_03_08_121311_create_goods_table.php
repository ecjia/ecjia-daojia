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

class CreateGoodsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		RC_Schema::create('goods', function(Blueprint $table)
		{
		    $table->increments('goods_id');
		    $table->integer('store_id')->unsigned()->default('0')->index('store_id');
		    $table->smallInteger('cat_id')->unsigned()->default('0')->index('cat_id');
		    $table->smallInteger('merchant_cat_id')->unsigned()->default('0');
		    $table->string('goods_sn', 60)->nullable()->index('goods_sn');
		    $table->string('goods_name', 120);
		    $table->string('goods_name_style', 60)->default('+');
		    $table->integer('click_count')->unsigned()->default('0');
		    $table->smallInteger('brand_id')->unsigned()->default('0')->index('brand_id');
		    $table->string('provider_name', 100)->nullable();
		    $table->smallInteger('goods_number')->unsigned()->default('0')->index('goods_number');
		    $table->decimal('goods_weight', 10, 3)->unsigned()->default('0.000')->index('goods_weight');
		    $table->integer('default_shipping')->unsigned()->default('0');
		    $table->decimal('market_price', 10, 2)->unsigned()->default('0.00');
		    $table->decimal('shop_price', 10, 2)->unsigned()->default('0.00');
		    $table->decimal('promote_price', 10, 2)->unsigned()->default('0.00');
		    $table->integer('promote_start_date')->unsigned()->default('0')->index('promote_start_date');
		    $table->integer('promote_end_date')->unsigned()->default('0')->index('promote_end_date');
		    $table->tinyInteger('warn_number')->unsigned()->default('1');
		    $table->string('keywords', 255)->nullable();
		    $table->string('goods_brief', 255)->nullable();
		    $table->text('goods_desc')->nullable();
		    $table->string('goods_thumb', 150)->nullable();
		    $table->string('goods_img', 150)->nullable();
		    $table->string('original_img', 150)->nullable();
		    $table->tinyInteger('is_real')->unsigned()->default('1');
		    $table->string('extension_code', 30)->nullable();
		    $table->tinyInteger('is_on_sale')->unsigned()->default('1');
		    $table->tinyInteger('is_alone_sale')->unsigned()->default('1');
		    $table->tinyInteger('is_shipping')->unsigned()->default('0');
		    $table->integer('integral')->unsigned()->default('0');
		    $table->integer('add_time')->unsigned()->default('0');
		    $table->smallInteger('sort_order')->unsigned()->default('100')->index('sort_order');
		    $table->smallInteger('store_sort_order')->unsigned()->default('100');
		    $table->tinyInteger('is_delete')->unsigned()->default('0');
		    $table->tinyInteger('is_best')->unsigned()->default('0');
		    $table->tinyInteger('is_new')->unsigned()->default('0');
		    $table->tinyInteger('is_hot')->unsigned()->default('0');
		    $table->tinyInteger('is_promote')->unsigned()->default('0');
		    $table->tinyInteger('bonus_type_id')->unsigned()->default('0');
		    $table->integer('last_update')->unsigned()->default('0')->index('last_update');
		    $table->smallInteger('goods_type')->unsigned()->default('0');
		    $table->string('seller_note', 255)->nullable();
		    $table->integer('give_integral')->default('-1');
		    $table->integer('rank_integral')->default('-1');
		    $table->smallInteger('suppliers_id')->unsigned()->default('0');
		    $table->tinyInteger('is_check')->unsigned()->default('0');
		    $table->tinyInteger('store_hot')->unsigned()->default('0');
		    $table->tinyInteger('store_new')->unsigned()->default('0');
		    $table->tinyInteger('store_best')->unsigned()->default('0');
		    $table->smallInteger('group_number')->unsigned()->default('0');
		    $table->tinyInteger('is_xiangou')->unsigned()->default('0')->comment('是否限购');
		    $table->integer('xiangou_start_date')->unsigned()->default('0')->comment('限购开始时间')->index('xiangou_start_date');
		    $table->integer('xiangou_end_date')->unsigned()->default('0')->comment('限购结束时间')->index('xiangou_end_date');
		    $table->integer('xiangou_num')->unsigned()->default('0')->comment('限购设定数量');
		    $table->tinyInteger('review_status')->unsigned()->default('1');
		    $table->string('review_content', 255)->nullable();
		    $table->text('goods_shipai')->nullable();
		    $table->integer('comments_number')->unsigned()->default('0');
		    $table->integer('sales_volume')->unsigned()->default('0')->index('sales_volume');
		    $table->tinyInteger('model_price')->unsigned()->default('0');
		    $table->tinyInteger('model_inventory')->unsigned()->default('0');
		    $table->tinyInteger('model_attr')->unsigned()->default('0');
		    $table->decimal('largest_amount', 10, 2)->unsigned()->default('0.00');
		    $table->string('pinyin_keyword', 200)->nullable();
		    $table->string('goods_product_tag', 200)->nullable();
		    
		    $table->unique(array('goods_id', 'store_id'), 'store_goods');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		RC_Schema::drop('goods');
	}

}
