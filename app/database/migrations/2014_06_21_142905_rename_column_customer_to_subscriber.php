<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameColumnCustomerToSubscriber extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('visits',function (Blueprint $table)
		{
			$table->renameColumn('customer_id','subscriber_id');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('visits',function (Blueprint $table)
		{
			$table->renameColumn('subscriber_id','customer_id');
		});
	}

}
