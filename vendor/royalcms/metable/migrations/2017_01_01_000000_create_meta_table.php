<?php

use Royalcms\Component\Database\Migrations\Migration;
use Royalcms\Component\Database\Schema\Blueprint;

class CreateMetaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        RC_Schema::create('meta', function (Blueprint $table) {
            $table->increments('id');
            $table->string('metable_type');
            $table->unsignedInteger('metable_id');
            $table->string('type')->default('null');
            $table->string('key')->index();
            $table->longtext('value');

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
