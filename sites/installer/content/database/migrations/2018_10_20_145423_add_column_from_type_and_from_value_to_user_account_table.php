<?php

use Royalcms\Component\Database\Schema\Blueprint;
use Royalcms\Component\Database\Migrations\Migration;

class AddColumnFromTypeAndFromValueToUserAccountTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (! RC_Schema::hasTable('user_account')) {
            return ;
        }

        //添加字段
        RC_Schema::table('user_account', function (Blueprint $table) {
            if (!RC_Schema::hasColumn('user_account', 'from_type')) $table->string('from_type', 60)->nullable()->comment('充值/提现来源类型（user,merchant,admin）')->after('user_note');
            if (!RC_Schema::hasColumn('user_account', 'from_value')) $table->string('from_value', 60)->nullable()->comment('充值/提现来源类型对应的id（用户/商家/平台管理员对应的id）')->after('from_type');
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
        RC_Schema::table('user_account', function (Blueprint $table) {
            $table->dropColumn('from_type');
            $table->dropColumn('from_value');
        });
    }
}
