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

class CreateWechatMediaTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        if (RC_Schema::hasTable('wechat_media')) {
            return ;
        }

		RC_Schema::create('wechat_media', function(Blueprint $table)
		{
		    $table->increments('id')->comment('自增 ID 号');
		    $table->integer('wechat_id')->unsigned()->default('0')->comment('微信id');
		    $table->string('title', 255)->nullable()->comment('图文消息标题');
		    $table->string('command', 20)->comment('关键词');
		    $table->string('author', 20)->nullable()->comment('昵称');

		    $table->tinyInteger('is_show')->unsigned()->default('0')->comment('是否显示封面，1为显示，0为不显示');
		    $table->string('digest', 255)->nullable()->comment('图文消息的描述');
		    $table->text('content')->nullable()->comment('图文消息页面的内容，支持HTML标签');
		    $table->string('link', 255)->nullable()->comment('点击图文消息跳转链接');
		    $table->string('file', 255)->nullable()->comment('图片链接');
		    
		    $table->integer('size')->unsigned()->default('0')->comment('媒体文件上传后，获取时的唯一标识');
		    $table->string('file_name', 255)->nullable()->comment('媒体文件上传时间戳');
		    $table->string('thumb', 255)->nullable()->comment('封面素材的id');
		    $table->integer('add_time')->unsigned()->default('0')->comment('添加时间');
		    $table->integer('edit_time')->unsigned()->default('0')->comment('修改时间');
		    
		    $table->string('type', 10)->nullable()->comment('素材类型（news图文消息，image图片，voice语音，video视频）');
		    $table->string('article_id', 100)->nullable()->comment('文章id');
		    $table->integer('sort')->unsigned()->default('0')->comment('排序');
		    $table->string('media_id', 255)->nullable()->comment('图文消息的ID');
		    $table->string('is_material', 20)->nullable();
		    
		    $table->string('media_url', 255)->nullable()->comment('封面素材地址链接');
		    $table->integer('parent_id')->unsigned()->default('0')->comment('数据库模型概述');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		RC_Schema::drop('wechat_media');
	}

}
