<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBillTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('bill', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('user_id');
			$table->string('category',40);
			$table->string('Reference',40);
			$table->string('type',20);
			$table->string('from',100);
			$table->string('to',100);
			$table->text('remarks');
			$table->timestamps();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('bill');
	}

}
