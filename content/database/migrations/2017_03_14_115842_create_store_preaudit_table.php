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

class CreateStorePreauditTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		RC_Schema::create('store_preaudit', function(Blueprint $table)
		{
		    $table->increments('id');
		    $table->integer('store_id')->unsigned()->default('0')->index('store_id');
		    $table->smallInteger('cat_id')->unsigned()->default('0');
		    $table->tinyInteger('validate_type')->default('1')->comment('入驻类型');
		    $table->string('merchants_name', 60)->comment('店铺名称');
		    $table->string('shop_keyword', 50)->nullable()->comment('店铺关键字');
		    $table->tinyInteger('check_status')->default('1')->index('status')->comment('店铺审核状态 1待审核,2通过，3不通过');
		    $table->tinyInteger('identity_status')->default('0')->comment('证件认证状态，0待审核，1审核中，2审核通过，3拒绝通过');
		    $table->string('responsible_person', 20)->nullable()->comment('责任人（法人代表或真实姓名）');
		    $table->string('company_name', 50)->nullable()->comment('公司名称');
		    $table->string('email', 60)->nullable()->unique('email')->comment('电子邮箱');
		    $table->string('contact_mobile', 20)->nullable()->unique('mobile')->comment('联系方式');
		    $table->integer('apply_time')->unsigned()->default('0')->comment('申请时间');
		    $table->integer('province')->unsigned()->default('0');
		    $table->integer('city')->unsigned()->default('0');
		    $table->integer('district')->unsigned()->default('0');
		    $table->string('address', 50)->nullable()->comment('详细地址');
		    $table->string('identity_type', 30)->nullable()->comment('证件类型1个人2企业');
		    $table->string('identity_number', 30)->nullable()->comment('证件号码');
		    $table->string('personhand_identity_pic', 100)->nullable()->comment('手持证件拍照');
		    $table->string('identity_pic_front', 100)->nullable()->comment('证件正面');
		    $table->string('identity_pic_back', 100)->nullable()->comment('证件反面');
		    $table->string('business_licence', 30)->nullable()->comment('营业执照注册号');
		    $table->string('business_licence_pic', 100)->nullable()->comment('营业执照');
		    $table->string('bank_account_name', 30)->nullable()->comment('账户名称');
		    $table->string('bank_name', 30)->nullable()->comment('收款银行');
		    $table->string('bank_branch_name', 30)->nullable()->comment('开户银行支行名称');
		    $table->string('bank_account_number', 30)->nullable()->comment('银行账号');
		    $table->string('bank_address', 50)->nullable()->comment('开户银行支行地址');
		    $table->string('remark', 100)->nullable()->comment('网站管理员备注信息');
		    $table->string('longitude', 20)->nullable()->comment('经度');
		    $table->string('latitude', 20)->nullable()->comment('纬度');
		    $table->string('geohash', 15)->nullable();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		RC_Schema::drop('store_preaudit');
	}

}
