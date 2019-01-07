<?php

use Royalcms\Component\Database\Schema\Blueprint;
use Royalcms\Component\Database\Migrations\Migration;

class CreateWithdrawMethodTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        RC_Schema::create('withdraw_method', function (Blueprint $table) {
            $table->increments('withdraw_id');
            $table->string('withdraw_code', 60);
            $table->string('withdraw_name', 120);
            $table->string('withdraw_fee', 10)->default('0');
            $table->text('withdraw_desc')->nullable();
            $table->integer('withdraw_order')->default('0');
            $table->text('withdraw_config')->nullable();
            $table->tinyInteger('enabled')->default('0');
            $table->tinyInteger('is_online')->default('0');

            $table->unique('withdraw_code', 'withdraw_code');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        RC_Schema::drop('withdraw_method');
    }
}
