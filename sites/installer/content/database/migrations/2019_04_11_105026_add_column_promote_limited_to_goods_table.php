<?php

use Royalcms\Component\Database\Schema\Blueprint;
use Royalcms\Component\Database\Migrations\Migration;

class AddColumnPromoteLimitedToGoodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (! RC_Schema::hasTable('goods')) {
            return ;
        }

        //添加字段
        RC_Schema::table('goods', function (Blueprint $table) {
            if (!RC_Schema::hasColumn('goods', 'promote_limited')) $table->smallInteger('promote_limited')->unsigned()->default('0')->comment('促销限制')->after('promote_end_date');
            if (!RC_Schema::hasColumn('goods', 'promote_user_limited')) $table->smallInteger('promote_user_limited')->unsigned()->default('0')->comment('促销用户限购')->after('promote_limited');
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
        RC_Schema::table('goods', function (Blueprint $table) {
            $table->dropColumn('promote_limited');
            $table->dropColumn('promote_user_limited');
        });
    }
}
