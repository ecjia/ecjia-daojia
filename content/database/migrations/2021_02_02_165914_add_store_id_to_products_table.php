<?php

use Royalcms\Component\Database\Schema\Blueprint;
use Royalcms\Component\Database\Migrations\Migration;

class AddStoreIdToProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        RC_Schema::table('products', function (Blueprint $table) {
            $table->integer('store_id')->unsigned()->default('0')->comment('店铺id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        RC_Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('store_id');
        });
    }
}
