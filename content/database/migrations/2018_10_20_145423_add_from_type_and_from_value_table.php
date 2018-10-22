<?php

use Royalcms\Component\Database\Schema\Blueprint;
use Royalcms\Component\Database\Migrations\Migration;

class AddFromTypeAndFromValueTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        RC_Schema::table('user_account', function (Blueprint $table) {
            $table->string('from_type', 60)->nullable()->comment('充值/提现来源类型（user,merchant,admin）')->after('user_note');
            $table->string('from_value', 60)->nullable()->comment('充值/提现来源类型对应的id（用户/商家/平台管理员对应的id）')->after('from_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        RC_Schema::table('user_account', function (Blueprint $table) {
            $table->dropColumn('from_type');
            $table->dropColumn('from_value');
        });
    }
}
