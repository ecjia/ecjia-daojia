<?php

use Royalcms\Component\Database\Schema\Blueprint;
use Royalcms\Component\Database\Migrations\Migration;

class AlterPrizeNumberAndPrizeProbToMarketActivityPrizeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        RC_Schema::table('market_activity_prize', function (Blueprint $table) {
            $table->integer('prize_number')->unsigned()->change();
            $table->decimal('prize_prob', 10, 2)->unsigned()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        RC_Schema::table('market_activity_prize', function (Blueprint $table) {
            //
        });
    }
}
