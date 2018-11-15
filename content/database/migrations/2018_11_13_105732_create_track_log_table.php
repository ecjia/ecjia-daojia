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
        RC_Schema::create('track_log', function (Blueprint $table) {
            $table->increments('log_id');
            $table->string('track_company', 30);
            $table->string('track_number', 30);
            $table->dateTime('time')->nullable();
            $table->string('context', 255)->nullable()->comment('描述');

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
