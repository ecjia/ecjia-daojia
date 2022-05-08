<?php

use Royalcms\Component\Database\Schema\Blueprint;
use Royalcms\Component\Database\Migrations\Migration;

class AddColumnWaitUploadArticleToWechatMedia extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        if (! RC_Schema::hasTable('wechat_media')) {
            return ;
        }

        //添加字段
		RC_Schema::table('wechat_media', function(Blueprint $table)
		{
            if (!RC_Schema::hasColumn('wechat_media', 'thumb_url')) $table->string('thumb_url', 255)->nullable()->comment('缩略图url')->after('media_url');
            if (!RC_Schema::hasColumn('wechat_media', 'need_open_comment')) $table->tinyInteger('need_open_comment')->nullable()->default('0')->comment('是否开启留言')->after('thumb_url');
            if (!RC_Schema::hasColumn('wechat_media', 'only_fans_can_comment')) $table->tinyInteger('only_fans_can_comment')->nullable()->default('0')->comment('仅关注后可留言')->after('need_open_comment');
            if (!RC_Schema::hasColumn('wechat_media', 'wait_upload_article')) $table->tinyInteger('wait_upload_article')->nullable()->default('0')->comment('待发布素材 1待发布 0已发布')->after('only_fans_can_comment');
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
		RC_Schema::table('wechat_media', function(Blueprint $table)
		{
            $table->dropColumn('thumb_url');
            $table->dropColumn('need_open_comment');
            $table->dropColumn('only_fans_can_comment');
            $table->dropColumn('wait_upload_article');
		});
	}

}
