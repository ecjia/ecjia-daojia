<?php

use Royalcms\Component\Database\Schema\Blueprint;
use Royalcms\Component\Database\Migrations\Migration;

class CreateUcenterFailedloginsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        RC_Schema::create('ucenter_failedlogins', function (Blueprint $table) {
            $table->string('ip', 60);
            $table->tinyInteger('count')->unsigned()->default('0');
            $table->integer('lastupdate')->unsigned()->default('0');

            $table->primary('ip', 'ip');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        RC_Schema::drop('ucenter_failedlogins');
    }
}
