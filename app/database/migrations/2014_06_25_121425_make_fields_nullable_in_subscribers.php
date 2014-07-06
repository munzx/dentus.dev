<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MakeFieldsNullableInSubscribers extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('subscribers',function(Blueprint $table)
		{
			DB::statement('alter table subscribers modify childern varchar(4)');
			DB::statement('alter table subscribers modify company_name varchar(100)');
			DB::statement('alter table subscribers modify company_city varchar(40)');
			DB::statement('alter table subscribers modify company_phone varchar(40)');
			DB::statement('alter table subscribers modify serial_number varchar(40)');
			DB::statement('alter table subscribers modify img_link varchar(200)');
			DB::statement('alter table subscribers modify active varchar(10)');
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
			$table->string('childern');
			$table->string('company_name',100);
			$table->string('company_city',100);
			$table->string('company_phone',100);
			$table->string('serial_number',20);
			$table->string('img_link',200);
			$table->string('active');
		});
	}

}
