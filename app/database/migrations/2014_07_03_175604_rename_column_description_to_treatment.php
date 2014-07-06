<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameColumnDescriptionToTreatment extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('visits',function(Blueprint $table)
		{
			$table->renameColumn('description','treatment');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('visits',function(Blueprint $table)
		{
			$table->renameColumn('treatment','description');
		});
	}

}
