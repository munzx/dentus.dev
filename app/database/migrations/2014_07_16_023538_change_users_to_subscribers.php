<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeUsersToSubscribers extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('users',function(Blueprint $table)
		{
			DB::update('UPDATE users SET role = "subscriber" WHERE role = "user" ');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('users',function(Blueprint $table)
		{
			DB::update('UPDATE users SET role = "user" WHERE role = "subscriber" ');
		});
	}

}
