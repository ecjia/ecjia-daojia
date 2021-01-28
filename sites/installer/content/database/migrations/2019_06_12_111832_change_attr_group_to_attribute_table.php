<?php

use Royalcms\Component\Database\Schema\Blueprint;
use Royalcms\Component\Database\Migrations\Migration;

class ChangeAttrGroupToAttributeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (! RC_Schema::hasTable('attribute')) {
            return ;
        }

        //修改字段
        $table = RC_DB::getTableFullName('attribute');
        RC_DB::statement("ALTER TABLE `$table` MODIFY `attr_group` VARCHAR(120) CHARACTER SET utf8mb4  COLLATE utf8mb4_unicode_ci  NULL  DEFAULT NULL  COMMENT '参数属性分组';");
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
