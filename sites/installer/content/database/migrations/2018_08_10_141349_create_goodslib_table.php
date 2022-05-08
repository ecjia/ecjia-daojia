<?php

use Royalcms\Component\Database\Schema\Blueprint;
use Royalcms\Component\Database\Migrations\Migration;

class CreateGoodslibTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        if (RC_Schema::hasTable('goodslib')) {
            return ;
        }

		RC_Schema::create('goodslib', function(Blueprint $table)
		{
            $table->increments('goods_id')->comment('主键，自增 ID 号');
            $table->smallInteger('cat_id')->unsigned()->default('0')->index('cat_id')->comment('分类id');
            $table->string('goods_sn', 60)->nullable()->index('goods_sn')->comment('商品的唯一货号');
            $table->string('goods_name', 120)->comment('商品的名称');
            $table->string('goods_name_style', 60)->default('+')->comment('商品名称显示的样式；包括颜色和字体样式；格式如#ff00ff+strong');
            $table->smallInteger('brand_id')->unsigned()->default('0')->index('brand_id')->comment('品牌id，取值于brand的brand_i');
            $table->string('provider_name', 100)->nullable();
            $table->decimal('goods_weight', 10, 3)->unsigned()->default('0.000')->index('goods_weight')->comment('商品的重量，以千克为单位');
            $table->decimal('market_price', 10, 2)->unsigned()->default('0.00')->comment('市场售价');
            $table->decimal('shop_price', 10, 2)->unsigned()->default('0.00')->comment('本店售价');
            $table->string('keywords', 255)->nullable()->comment('关键字');
            $table->string('pinyin_keyword', 200)->nullable()->comment('暂未使用');
            $table->string('goods_brief', 255)->nullable()->comment('商品的简短描述');
            $table->text('goods_desc')->nullable()->comment('商品描述');
            $table->string('goods_thumb', 150)->nullable()->comment('商品在前台显示的微缩图片，如在分类筛选时显示的小图片');
            $table->string('goods_img', 150)->nullable()->comment('商品的实际大小图片，如进入该商品页时介绍商品属性所显示的大图片');
            $table->string('original_img', 150)->nullable()->comment('上传的商品的原始图片');
            $table->tinyInteger('is_real')->unsigned()->default('1')->comment('是否是实物，1，是；0，否；比如虚拟卡就为0，不是实物');
            $table->string('extension_code', 30)->nullable()->comment('商品的扩展属性，比如像虚拟卡');
            $table->integer('add_time')->unsigned()->default('0')->comment('添加时间');
            $table->smallInteger('sort_order')->unsigned()->default('100')->index('sort_order')->comment('排序');
            $table->tinyInteger('is_delete')->unsigned()->default('0')->comment('商品是否已经删除，0，否；1，已删除');
            $table->integer('last_update')->unsigned()->default('0')->index('last_update')->comment('最近一次更新商品配置的时间');
            $table->smallInteger('goods_type')->unsigned()->default('0')->comment('商品所属类型id，取值表goods_type的cat_id');
            $table->tinyInteger('review_status')->unsigned()->default('1')->comment('商品审核状态,1待审核，2不通过，3通过，5无需审核');
            $table->string('review_content', 255)->nullable()->comment('商品审核不通过内容');
            $table->smallInteger('goods_rank')->unsigned()->default('10000')->comment('好评率，10000=100.00%')->comment('好评率，10000=100.00%');
            $table->boolean('is_display')->unsigned()->default('0')->comment('是否显示在商家商品库，0不显示，1显示');
            $table->integer('used_count')->unsigned()->default('0')->comment('同步次数');

            $table->index('is_delete', 'is_delete');
            $table->index('is_display', 'is_display');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		RC_Schema::drop('goodslib');
	}

}
