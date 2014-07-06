<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemovePassportNumberFromSubscribers extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('subscribers',function (Blueprint $table)
		{
			$table->dropColumn('passport_number');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('subscribers',function(Blueprint $table)
		{
			$table->string('passport_number',40)->nullable();
		});
	}

}
