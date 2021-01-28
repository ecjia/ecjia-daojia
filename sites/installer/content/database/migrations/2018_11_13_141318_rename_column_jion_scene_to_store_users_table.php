<?php

use Royalcms\Component\Database\Schema\Blueprint;
use Royalcms\Component\Database\Migrations\Migration;

class RenameColumnJionSceneToStoreUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (! RC_Schema::hasTable('store_users')) {
            return ;
        }

        //重命名字段
        RC_Schema::table('store_users', function (Blueprint $table) {
            if (RC_Schema::hasColumn('store_users', 'jion_scene')) $table->renameColumn('jion_scene', 'join_scene');
            if (RC_Schema::hasColumn('store_users', 'jion_scene_str')) $table->renameColumn('jion_scene_str', 'join_scene_str');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //重命名字段
        RC_Schema::table('store_users', function (Blueprint $table) {
            $table->renameColumn('join_scene', 'jion_scene');
            $table->renameColumn('join_scene_str', 'jion_scene_str');
        });
    }
}
