<?php

use Royalcms\Component\Database\Schema\Blueprint;
use Royalcms\Component\Database\Migrations\Migration;

class AddAdDescToAdTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        RC_Schema::table('ad', function (Blueprint $table) {
            $table->text('ad_desc')->nullable()->comment('图片描述')->after('ad_code');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        RC_Schema::table('ad', function (Blueprint $table) {
            $table->dropColumn('ad_desc');
        });
    }
}
