<?php

use Royalcms\Component\Database\Schema\Blueprint;
use Royalcms\Component\Database\Migrations\Migration;

class CreateMetaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (RC_Schema::hasTable('meta')) {
            return ;
        }

        RC_Schema::create('meta', function (Blueprint $table) {
            $table->increments('id')->comment('自增ID');
            $table->string('metable_type', 150)->comment('meta表类型');
            $table->unsignedInteger('metable_id')->comment('meta表 ID');
            $table->string('type')->nullable()->default('null')->comment('类型');
            $table->string('key', 150)->index()->comment('主键');
            $table->longtext('value')->comment('值');

            $table->index(['metable_type', 'metable_id'], 'metable_type_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        RC_Schema::drop('meta');
    }
}
