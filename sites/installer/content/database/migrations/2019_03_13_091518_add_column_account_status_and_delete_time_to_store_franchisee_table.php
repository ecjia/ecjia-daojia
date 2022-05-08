<?php

use Royalcms\Component\Database\Schema\Blueprint;
use Royalcms\Component\Database\Migrations\Migration;

class AddColumnAccountStatusAndDeleteTimeToStoreFranchiseeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (! RC_Schema::hasTable('store_franchisee')) {
            return ;
        }

        //添加字段
        RC_Schema::table('store_franchisee', function (Blueprint $table) {
            if (!RC_Schema::hasColumn('store_franchisee', 'account_status')) $table->string('account_status', 30)->nullable()->default('normal')->comment('账户状态（normal正常，wait_delete已申请了账号注销待删除账号）')->after('expired_time');
            if (!RC_Schema::hasColumn('store_franchisee', 'delete_time')) $table->integer('delete_time')->unsigned()->default('0')->comment('账号申请注销时间')->after('account_status');
            if (!RC_Schema::hasColumn('store_franchisee', 'activate_time')) $table->integer('activate_time')->unsigned()->default('0')->comment('账号申请激活时间')->after('delete_time');
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
        RC_Schema::table('store_franchisee', function (Blueprint $table) {
            $table->dropColumn('account_status');
            $table->dropColumn('delete_time');
            $table->dropColumn('activate_time');
        });
    }
}
