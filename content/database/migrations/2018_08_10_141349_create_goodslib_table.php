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
		RC_Schema::create('goodslib', function(Blueprint $table)
		{
            $table->increments('goods_id');
            $table->smallInteger('cat_id')->unsigned()->default('0')->index('cat_id');
            $table->string('goods_sn', 60)->nullable()->index('goods_sn');
            $table->string('goods_name', 120);
            $table->string('goods_name_style', 60)->default('+');
            $table->smallInteger('brand_id')->unsigned()->default('0')->index('brand_id');
            $table->string('provider_name', 100)->nullable();
            $table->decimal('goods_weight', 10, 3)->unsigned()->default('0.000')->index('goods_weight');
            $table->decimal('market_price', 10, 2)->unsigned()->default('0.00');
            $table->decimal('shop_price', 10, 2)->unsigned()->default('0.00');
            $table->string('keywords', 255)->nullable();
            $table->string('pinyin_keyword', 200)->nullable();
            $table->string('goods_brief', 255)->nullable();
            $table->text('goods_desc')->nullable();
            $table->string('goods_thumb', 150)->nullable();
            $table->string('goods_img', 150)->nullable();
            $table->string('original_img', 150)->nullable();
            $table->tinyInteger('is_real')->unsigned()->default('1');
            $table->string('extension_code', 30)->nullable();
            $table->integer('add_time')->unsigned()->default('0');
            $table->smallInteger('sort_order')->unsigned()->default('100')->index('sort_order');
            $table->tinyInteger('is_delete')->unsigned()->default('0');
            $table->integer('last_update')->unsigned()->default('0')->index('last_update');
            $table->smallInteger('goods_type')->unsigned()->default('0');
            $table->tinyInteger('review_status')->unsigned()->default('1');
            $table->string('review_content', 255)->nullable();
            $table->smallInteger('goods_rank')->unsigned()->default('10000')->comment('好评率，10000=100.00%');
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
