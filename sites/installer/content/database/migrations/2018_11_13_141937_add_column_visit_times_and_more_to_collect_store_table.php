<?php

use Royalcms\Component\Database\Schema\Blueprint;
use Royalcms\Component\Database\Migrations\Migration;

class AddColumnVisitTimesAndMoreToCollectStoreTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (! RC_Schema::hasTable('collect_store')) {
            return ;
        }

        //添加字段
        RC_Schema::table('collect_store', function (Blueprint $table) {
            if (!RC_Schema::hasColumn('collect_store', 'visit_times')) $table->integer('visit_times')->unsigned()->default('0')->comment('访问次数')->after('is_attention');
            if (!RC_Schema::hasColumn('collect_store', 'last_visit_time')) $table->integer('last_visit_time')->unsigned()->default('0')->comment('最后访问时间')->after('visit_times');
            if (!RC_Schema::hasColumn('collect_store', 'last_visit_longitude')) $table->string('last_visit_longitude', 20)->nullable()->comment('用户经度位置')->after('last_visit_time');
            if (!RC_Schema::hasColumn('collect_store', 'last_visit_latitude')) $table->string('last_visit_latitude', 20)->nullable()->comment('用户纬度位置')->after('last_visit_longitude');
            if (!RC_Schema::hasColumn('collect_store', 'last_visit_ip')) $table->string('last_visit_ip', 45)->nullable()->comment('最后访问IP')->after('last_visit_latitude');
            if (!RC_Schema::hasColumn('collect_store', 'last_visit_area')) $table->string('last_visit_area', 255)->nullable()->default('0')->comment('最后访问地区')->after('last_visit_ip');
            if (!RC_Schema::hasColumn('collect_store', 'is_store_user')) $table->tinyInteger('is_store_user')->unsigned()->default('0')->comment('是否会员，0不是，1是')->after('last_visit_area');
            if (!RC_Schema::hasColumn('collect_store', 'referer')) $table->string('referer', 60)->nullable()->comment('来源')->after('is_store_user');
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
        RC_Schema::table('collect_store', function (Blueprint $table) {
            $table->dropColumn('visit_times');
            $table->dropColumn('last_visit_time');
            $table->dropColumn('last_visit_longitude');
            $table->dropColumn('last_visit_latitude');
            $table->dropColumn('last_visit_ip');
            $table->dropColumn('last_visit_area');
            $table->dropColumn('is_store_user');
            $table->dropColumn('referer');
        });
    }
}
