<?php

use Royalcms\Component\Database\Schema\Blueprint;
use Royalcms\Component\Database\Migrations\Migration;

class AddColumnAdDescToAdTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (! RC_Schema::hasTable('ad')) {
            return ;
        }

        //添加字段
        RC_Schema::table('ad', function (Blueprint $table) {
            if (!RC_Schema::hasColumn('ad', 'ad_desc')) $table->text('ad_desc')->nullable()->comment('图片描述')->after('ad_code');
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
        RC_Schema::table('ad', function (Blueprint $table) {
            $table->dropColumn('ad_desc');
        });
    }
}
