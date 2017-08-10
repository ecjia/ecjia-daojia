<?php

use Royalcms\Component\Database\Schema\Blueprint;
use Royalcms\Component\Database\Migrations\Migration;

class AddOrderTradeNoToPaymentRecordTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
	    RC_Schema::table('payment_record', function(Blueprint $table)
	    {
	        $table->dropUnique('order_sn');
	    });
	    
	    RC_Schema::table('payment_record', function(Blueprint $table)
	    {
	        $table->string('order_sn', 30)->change();
	    });
	    
		RC_Schema::table('payment_record', function(Blueprint $table)
		{
		    $table->string('order_trade_no', 60)->nullable()->after('order_sn');
		    $table->string('partner_id', 60)->comment('商户号')->after('pay_time');
		    $table->string('account', 60)->comment('收款帐号')->after('partner_id');

		    $table->index('order_trade_no', 'order_trade_no');
		    $table->index('order_sn', 'order_sn');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
	    RC_Schema::table('payment_record', function(Blueprint $table)
	    {
	        $table->dropIndex('order_sn');
	        $table->dropIndex('order_trade_no');
	        
	        $table->dropColumn('order_trade_no');
	        $table->dropColumn('partner_id');
	        $table->dropColumn('account');
	    });
	    
		RC_Schema::table('payment_record', function(Blueprint $table)
		{
			$table->string('order_sn', 20)->change();
			
			$table->unique('order_sn', 'order_sn');
		});
	}

}
