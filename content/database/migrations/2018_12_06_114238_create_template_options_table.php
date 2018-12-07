<?php

use Royalcms\Component\Database\Schema\Blueprint;
use Royalcms\Component\Database\Migrations\Migration;

class CreateTemplateOptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        RC_Schema::create('template_options', function (Blueprint $table) {
            $table->increments('option_id');
            $table->string('option_name', 100)->comment('选项');
            $table->longText('option_value')->nullable()->comment('选项值');
            $table->string('site', 30)->nullable()->comment('站点');
            $table->string('template', 60)->nullable()->comment('模板');

            $table->unique(['site', 'template', 'option_name'], 'option_name');
            $table->index('site', 'site');
            $table->index('template', 'template');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        RC_Schema::drop('template_options');
    }
}
