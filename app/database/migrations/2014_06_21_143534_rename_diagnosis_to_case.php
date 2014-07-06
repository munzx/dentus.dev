<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameDiagnosisToCase extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('visits',function (Blueprint $table)
		{
			$table->renameColumn('diagnosis','case');
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
			$table->renameColumn('case','diagnosis');
		});
	}

}
