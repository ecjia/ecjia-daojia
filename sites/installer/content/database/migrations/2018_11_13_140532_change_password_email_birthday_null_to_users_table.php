<?php

use Royalcms\Component\Database\Schema\Blueprint;
use Royalcms\Component\Database\Migrations\Migration;

class ChangePasswordEmailBirthdayNullToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (! RC_Schema::hasTable('users')) {
            return ;
        }

        //修改字段
        RC_Schema::table('users', function (Blueprint $table) {
            $table->string('password', 32)->nullable()->change();
            $table->string('email', 60)->nullable()->change();
            $table->date('birthday')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //修改字段
        RC_Schema::table('users', function (Blueprint $table) {
            $table->string('password', 32)->change();
            $table->string('email', 60)->change();
            $table->date('birthday')->change();
        });
    }
}
