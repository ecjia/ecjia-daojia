<?php

use Royalcms\Component\Database\Schema\Blueprint;
use Royalcms\Component\Database\Migrations\Migration;

class CreateAgentUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (RC_Schema::hasTable('agent_user')) {
            return ;
        }

        RC_Schema::create('agent_user', function (Blueprint $table) {
            $table->integer('user_id');
            $table->string('rank_code', 20)->comment('代理等级code');
            $table->string('province', 20)->comment('省');
            $table->string('city', 20)->comment('市');
            $table->string('district', 20)->comment('区');

            $table->primary('user_id', 'user_id');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        RC_Schema::drop('agent_user');
    }
}
