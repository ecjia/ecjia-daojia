<?php

use Royalcms\Component\Database\Schema\Blueprint;
use Royalcms\Component\Database\Migrations\Migration;

class AddPromoteLimitedToGoodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        RC_Schema::table('goods', function (Blueprint $table) {
            $table->smallInteger('promote_limited')->unsigned()->default('0')->comment('促销限制')->after('promote_end_date');
            $table->smallInteger('promote_user_limited')->unsigned()->default('0')->comment('促销用户限购')->after('promote_limited');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        RC_Schema::table('goods', function (Blueprint $table) {
            $table->dropColumn('promote_limited');
            $table->dropColumn('promote_user_limited');
        });
    }
}
