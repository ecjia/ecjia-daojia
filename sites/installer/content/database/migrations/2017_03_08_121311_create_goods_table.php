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
        if (RC_Schema::hasTable('goods')) {
            return ;
        }

		RC_Schema::create('goods', function(Blueprint $table)
		{
		    $table->increments('goods_id')->comment('商品id');
		    $table->integer('store_id')->unsigned()->default('0')->index('store_id')->comment('店铺id');
		    $table->smallInteger('cat_id')->unsigned()->default('0')->index('cat_id')->comment('商品所属平台商品分类id,取值category的cat_id');
		    $table->smallInteger('merchant_cat_id')->unsigned()->default('0')->comment('商品所属商家商品分类id，取值merchants_category的cat_id');
		    $table->string('goods_sn', 60)->nullable()->index('goods_sn')->comment('商品的唯一货号');
		    $table->string('goods_name', 120)->comment('商品的名称');
		    $table->string('goods_name_style', 60)->default('+')->comment('商品名称显示的样式；包括颜色和字体样式；格式如#ff00ff+strong');
		    $table->integer('click_count')->unsigned()->default('0')->comment('商品点击数');
		    $table->smallInteger('brand_id')->unsigned()->default('0')->index('brand_id')->comment('品牌id，取值于brand的brand_id');
		    $table->string('provider_name', 100)->nullable()->comment('供货人的名称，程序还没实现该功能');
		    $table->smallInteger('goods_number')->unsigned()->default('0')->index('goods_number')->comment('商品库存数量');
		    $table->decimal('goods_weight', 10, 3)->unsigned()->default('0.000')->index('goods_weight')->comment('商品的重量，以千克为单位');
		    $table->integer('default_shipping')->unsigned()->default('0')->comment('默认配送');
		    $table->decimal('market_price', 10, 2)->unsigned()->default('0.00')->comment('市场售价');
		    $table->decimal('shop_price', 10, 2)->unsigned()->default('0.00')->comment('本店售价');
		    $table->decimal('promote_price', 10, 2)->unsigned()->default('0.00')->comment('促销价格');
		    $table->integer('promote_start_date')->unsigned()->default('0')->index('promote_start_date')->comment('促销价格开始日期');
		    $table->integer('promote_end_date')->unsigned()->default('0')->index('promote_end_date')->comment('促销价格结束日期');
		    $table->tinyInteger('warn_number')->unsigned()->default('1')->comment('商品报警数量');
		    $table->string('keywords', 255)->nullable()->comment('商品关键字，放在商品页的关键字中，为搜索引擎收录用');
		    $table->string('goods_brief', 255)->nullable()->comment('商品的简短描述');
		    $table->text('goods_desc')->nullable()->comment('商品的详细描述');
		    $table->string('goods_thumb', 150)->nullable()->comment('商品在前台显示的微缩图片，如在分类筛选时显示的小图片');
		    $table->string('goods_img', 150)->nullable()->comment('商品的实际大小图片，如进入该商品页时介绍商品属性所显示的大图片');
		    $table->string('original_img', 150)->nullable()->comment('上传的商品的原始图片');
		    $table->tinyInteger('is_real')->unsigned()->default('1')->comment('是否是实物，1，是；0，否；比如虚拟卡就为0，不是实物');
		    $table->string('extension_code', 30)->nullable()->comment('商品的扩展属性，比如像虚拟卡');
		    $table->tinyInteger('is_on_sale')->unsigned()->default('1')->comment('该商品是否开放销售，1，是；0，否');
		    $table->tinyInteger('is_alone_sale')->unsigned()->default('1')->comment('是否能单独销售，1，是；0，否；如果不能单独销售，则只能作为某商品的配件或者赠品销售');
		    $table->tinyInteger('is_shipping')->unsigned()->default('0')->comment('是否购买');
		    $table->integer('integral')->unsigned()->default('0')->comment('购买该商品可以使用的积分数量，估计应该是用积分代替金额消费；但程序好像还没有实现该功能');
		    $table->integer('add_time')->unsigned()->default('0')->comment('商品的添加时间');
		    $table->smallInteger('sort_order')->unsigned()->default('100')->index('sort_order')->comment('平台对商品的显示排序');
		    $table->smallInteger('store_sort_order')->unsigned()->default('100')->comment('商家对商品的显示排序');
		    $table->tinyInteger('is_delete')->unsigned()->default('0')->comment('商品是否已经删除，0，否；1，已删除');
		    $table->tinyInteger('is_best')->unsigned()->default('0')->comment('是否是精品；0，否；1，是');
		    $table->tinyInteger('is_new')->unsigned()->default('0')->comment('是否是新品');
		    $table->tinyInteger('is_hot')->unsigned()->default('0')->comment('是否热销，0，否；1，是');
		    $table->tinyInteger('is_promote')->unsigned()->default('0')->comment('是否特价促销；0，否；1，是');
		    $table->tinyInteger('bonus_type_id')->unsigned()->default('0')->comment('购买该商品所能领到的红包类型');
		    $table->integer('last_update')->unsigned()->default('0')->index('last_update')->comment('最近一次更新商品配置的时间');
		    $table->smallInteger('goods_type')->unsigned()->default('0')->comment('商品所属类型id，取值表goods_type的cat_id');
		    $table->string('seller_note', 255)->nullable()->comment('商品的商家备注，仅商家可见');
		    $table->integer('give_integral')->default('-1')->comment('购买该商品时每笔成功交易赠送的积分数量');
		    $table->integer('rank_integral')->default('-1')->comment('等级积分');
		    $table->smallInteger('suppliers_id')->unsigned()->default('0')->comment('供货商id');
		    $table->tinyInteger('is_check')->unsigned()->default('0')->comment('是否检查');
		    $table->tinyInteger('store_hot')->unsigned()->default('0')->comment('商家加入推荐（0非热销，1热销）');
		    $table->tinyInteger('store_new')->unsigned()->default('0')->comment('商家加入推荐（0非新品，1新品）');
		    $table->tinyInteger('store_best')->unsigned()->default('0')->comment('商家加入推荐（0非精品，1精品）');
		    $table->smallInteger('group_number')->unsigned()->default('0')->comment('组合购买限制数量');
		    $table->tinyInteger('is_xiangou')->unsigned()->default('0')->comment('是否限购');
		    $table->integer('xiangou_start_date')->unsigned()->default('0')->comment('限购开始时间')->index('xiangou_start_date');
		    $table->integer('xiangou_end_date')->unsigned()->default('0')->comment('限购结束时间')->index('xiangou_end_date');
		    $table->integer('xiangou_num')->unsigned()->default('0')->comment('限购设定数量');
		    $table->tinyInteger('review_status')->unsigned()->default('1')->comment('商品审核状态,1待审核，2不通过，3通过，5无需审核');
		    $table->string('review_content', 255)->nullable()->comment('商品审核不通过内容');
		    $table->text('goods_shipai')->nullable()->comment('暂未使用');
		    $table->integer('comments_number')->unsigned()->default('0')->comment('评论数');
		    $table->integer('sales_volume')->unsigned()->default('0')->index('sales_volume')->comment('商品销量');
		    $table->tinyInteger('model_price')->unsigned()->default('0')->comment('商品价格模式（0-默认，1-仓库，2-地区）');
		    $table->tinyInteger('model_inventory')->unsigned()->default('0')->comment('商品库存模式（0-默认，1-仓库，2-地区）');
		    $table->tinyInteger('model_attr')->unsigned()->default('0')->comment('商品属性模式（0-默认，1-仓库，2-地区）');
		    $table->decimal('largest_amount', 10, 2)->unsigned()->default('0.00')->comment('暂未使用');
		    $table->string('pinyin_keyword', 200)->nullable()->comment('暂未使用');
		    $table->string('goods_product_tag', 200)->nullable()->comment('商品标签（暂未使用）');
		    
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
