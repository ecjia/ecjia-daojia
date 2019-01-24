<?php

use Royalcms\Component\Database\Schema\Blueprint;
use Royalcms\Component\Database\Migrations\Migration;

class AddConnectPlatformAndUnionIdToConnectUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        RC_Schema::table('connect_user', function (Blueprint $table) {
            $table->string('connect_platform', 60)->nullable()->comment('对接平台')->after('connect_code');
            $table->string('union_id', 60)->nullable()->after('open_id');

            $table->index('connect_platform', 'connect_platform');
            $table->index('union_id', 'union_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        RC_Schema::table('connect_user', function (Blueprint $table) {
            $table->dropColumn('connect_platform');
            $table->dropColumn('union_id');
        });
    }
}
