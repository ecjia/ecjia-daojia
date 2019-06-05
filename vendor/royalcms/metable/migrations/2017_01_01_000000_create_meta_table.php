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
            $table->string('metable_type', 150);
            $table->unsignedInteger('metable_id');
            $table->string('type')->nullable()->default('null');
            $table->string('key', 150)->index();
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
