<?php

class AdminsTableSeeder extends Seeder {

	public function run()
	{
		// Uncomment the below to wipe the table clean before populating
		DB::table('admins')->truncate();

		$users = array(
			[
				'first_name'=>'Ahmed',
				'last_name'=>'Osamn',
				'email'=>'ahmed.osman@dentus.me',
				'password'=>Hash::make('Dentus@123')
			],
			[
				'first_name'=>'Fares',
				'last_name'=>'Younis',
				'email'=>'fares.a.younis@dentus.me',
				'password'=>Hash::make('Dentus@123')
			]
		);

		// Uncomment the below to run the seeder
		DB::table('admins')->insert($users);
	}

}
