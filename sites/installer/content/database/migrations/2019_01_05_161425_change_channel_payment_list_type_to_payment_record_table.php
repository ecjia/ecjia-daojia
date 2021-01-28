<?php

use Royalcms\Component\Database\Schema\Blueprint;
use Royalcms\Component\Database\Migrations\Migration;

class ChangeChannelPaymentListTypeToPaymentRecordTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (! RC_Schema::hasTable('payment_record')) {
            return ;
        }

        //修改字段
        RC_Schema::table('payment_record', function (Blueprint $table) {
            $table->text('channel_payment_list')->change();
        });
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
