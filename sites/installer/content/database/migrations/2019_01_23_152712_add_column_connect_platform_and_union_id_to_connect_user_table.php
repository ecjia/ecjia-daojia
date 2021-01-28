<?php

use Royalcms\Component\Database\Schema\Blueprint;
use Royalcms\Component\Database\Migrations\Migration;

class AddColumnConnectPlatformAndUnionIdToConnectUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (! RC_Schema::hasTable('connect_user')) {
            return ;
        }

        //添加字段
        RC_Schema::table('connect_user', function (Blueprint $table) {
            if (!RC_Schema::hasColumn('connect_user', 'connect_platform')) $table->string('connect_platform', 60)->nullable()->comment('对接平台')->after('connect_code');
            if (!RC_Schema::hasColumn('connect_user', 'union_id')) $table->string('union_id', 60)->nullable()->after('open_id');
        });

        //添加索引
        RC_Schema::table('connect_user', function(Blueprint $table)
        {
            if (!$table->hasIndex('connect_platform')) $table->index('connect_platform', 'connect_platform');
            if (!$table->hasIndex('union_id')) $table->index('union_id', 'union_id');
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
        RC_Schema::table('connect_user', function (Blueprint $table) {
            if (RC_Schema::hasColumn('connect_user', 'connect_platform')) $table->dropColumn('connect_platform');
            if (RC_Schema::hasColumn('connect_user', 'union_id')) $table->dropColumn('union_id');
        });
    }
}
