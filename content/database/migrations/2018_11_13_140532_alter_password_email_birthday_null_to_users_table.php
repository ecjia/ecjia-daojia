<?php

use Royalcms\Component\Database\Schema\Blueprint;
use Royalcms\Component\Database\Migrations\Migration;

class AlterPasswordEmailBirthdayNullToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
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
        RC_Schema::table('users', function (Blueprint $table) {
            $table->string('password', 32)->change();
            $table->string('email', 60)->change();
            $table->date('birthday')->change();
        });
    }
}
