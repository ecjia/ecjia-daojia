<?php

use Royalcms\Component\Database\Schema\Blueprint;
use Royalcms\Component\Database\Migrations\Migration;

class AddColumnActionUserTypeToRefundPayrecordTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (! RC_Schema::hasTable('refund_payrecord')) {
            return ;
        }

        //添加字段
        RC_Schema::table('refund_payrecord', function (Blueprint $table) {
            if (!RC_Schema::hasColumn('refund_payrecord', 'action_user_type')) $table->string('action_user_type', 60)->nullable()->comment('操作用户类型（admin平台管理员，merchant商家管理员）')->after('action_back_time');
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
        RC_Schema::table('refund_payrecord', function (Blueprint $table) {
            $table->dropColumn('action_user_type');
        });
    }
}
