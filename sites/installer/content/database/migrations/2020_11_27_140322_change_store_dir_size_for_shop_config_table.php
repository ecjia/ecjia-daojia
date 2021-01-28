<?php

use Royalcms\Component\Database\Migrations\Migration;

class ChangeStoreDirSizeForShopConfigTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (! RC_Schema::hasTable('shop_config')) {
            return ;
        }

        //修改字段
        $table = RC_DB::getTableFullName('shop_config');
        RC_DB::statement("ALTER TABLE `$table` MODIFY `store_dir` VARCHAR(255) NULL  DEFAULT NULL;");
        RC_DB::statement("ALTER TABLE `$table` MODIFY `store_range` VARCHAR(255) NULL  DEFAULT NULL;");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

    }
}
