<?php

use Royalcms\Component\Database\Schema\Blueprint;
use Royalcms\Component\Database\Migrations\Migration;

class CreateUcenterProtectedmembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        RC_Schema::create('ucenter_protectedmembers', function (Blueprint $table) {
            $table->integer('user_id')->unsigned()->default('0');
            $table->string('user_name', 60);
            $table->integer('appid')->unsigned()->default('0');
            $table->integer('dateline')->unsigned()->default('0');
            $table->string('admin', 60)->default('0');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        RC_Schema::drop('ucenter_protectedmembers');
    }
}
