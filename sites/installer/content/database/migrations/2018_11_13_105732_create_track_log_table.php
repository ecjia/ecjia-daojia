<?php

use Royalcms\Component\Database\Schema\Blueprint;
use Royalcms\Component\Database\Migrations\Migration;

class CreateTrackLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (RC_Schema::hasTable('track_log')) {
            return ;
        }

        RC_Schema::create('track_log', function (Blueprint $table) {
            $table->increments('log_id')->comment('日志ID');
            $table->string('track_company', 30)->comment('快递公司');
            $table->string('track_number', 30)->comment('快递运单编号');
            $table->dateTime('time')->nullable()->comment('时间');
            $table->string('context', 255)->nullable()->comment('内容');

            $table->index('track_number', 'track_number');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        RC_Schema::drop('track_log');
    }
}
