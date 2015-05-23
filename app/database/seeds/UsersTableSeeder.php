<?php

class UsersTableSeeder extends Seeder {

	public function run()
	{
		// Uncomment the below to wipe the table clean before populating
		DB::table('users')->truncate();


		$users = array(
			[
				'first_name'=>'Ahmed',
				'last_name'=>'Osman',
				'email'=>'ahmed.osman@dentus.me',
				'password'=>Hash::make('Dentus@123'),
				'role'=>'admin',
				'source_id'=>'1'
			],
			[
				'first_name'=>'Fares',
				'last_name'=>'Younis',
				'email'=>'fares.a.younis@dentus.me',
				'password'=>Hash::make('Dentus@123'),
				'role'=>'admin',
				'source_id'=>'2'
			]
		);

		// Uncomment the below to run the seeder
		DB::table('users')->insert($users);
	}

}
