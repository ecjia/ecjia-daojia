<?php

use Royalcms\Component\Database\Schema\Blueprint;
use Royalcms\Component\Database\Migrations\Migration;

class AddColumnQrSceneAndLocationToWechatUser extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        if (! RC_Schema::hasTable('wechat_user')) {
            return ;
        }

        //添加字段
		RC_Schema::table('wechat_user', function(Blueprint $table)
		{
            if (!RC_Schema::hasColumn('wechat_user', 'subscribe_scene')) $table->string('subscribe_scene', 50)->nullable()->comment('返回用户关注的渠道来源，ADD_SCENE_SEARCH 公众号搜索，ADD_SCENE_ACCOUNT_MIGRATION 公众号迁移，ADD_SCENE_PROFILE_CARD 名片分享，ADD_SCENE_QR_CODE 扫描二维码，ADD_SCENEPROFILE LINK 图文页内名称点击，ADD_SCENE_PROFILE_ITEM 图文页右上角菜单，ADD_SCENE_PAID 支付后关注，ADD_SCENE_OTHERS 其他')->after('bein_kefu');
            if (!RC_Schema::hasColumn('wechat_user', 'qr_scene')) $table->integer('qr_scene')->nullable()->comment('二维码扫码场景')->after('subscribe_scene');
            if (!RC_Schema::hasColumn('wechat_user', 'qr_scene_str')) $table->string('qr_scene_str', 255)->nullable()->comment('二维码扫码场景描述')->after('qr_scene');
            if (!RC_Schema::hasColumn('wechat_user', 'popularize_uid')) $table->integer('popularize_uid')->unsigned()->nullable()->comment('推广用户的uid')->after('qr_scene_str');
            if (!RC_Schema::hasColumn('wechat_user', 'location_latitude')) $table->string('location_latitude', 20)->nullable()->comment('地理位置纬度')->after('popularize_uid');
            if (!RC_Schema::hasColumn('wechat_user', 'location_longitude')) $table->string('location_longitude', 20)->nullable()->comment('地理位置经度')->after('location_latitude');
            if (!RC_Schema::hasColumn('wechat_user', 'location_precision')) $table->string('location_precision', 20)->nullable()->comment('地理位置精度')->after('location_longitude');
            if (!RC_Schema::hasColumn('wechat_user', 'location_updatetime')) $table->integer('location_updatetime')->unsigned()->nullable()->comment('地理位置上报时间')->after('location_precision');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        //删除字段
		RC_Schema::table('wechat_user', function(Blueprint $table)
		{
            $table->dropColumn('subscribe_scene');
            $table->dropColumn('qr_scene');
            $table->dropColumn('qr_scene_str');
            $table->dropColumn('popularize_uid');
            $table->dropColumn('location_latitude');
            $table->dropColumn('location_longitude');
            $table->dropColumn('location_precision');
            $table->dropColumn('location_updatetime');
		});
	}

}
