<?php

use Royalcms\Component\Database\Schema\Blueprint;
use Royalcms\Component\Database\Migrations\Migration;

class AddActionUserTypeToRefundPayrecordTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        RC_Schema::table('refund_payrecord', function (Blueprint $table) {
            $table->string('action_user_type', 60)->nullable()->comment('操作用户类型（admin平台管理员，merchant商家管理员）')->after('action_back_time');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        RC_Schema::table('refund_payrecord', function (Blueprint $table) {
            $table->dropColumn('action_user_type');
        });
    }
}
