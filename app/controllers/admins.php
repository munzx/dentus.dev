<?php

class admins extends \BaseController {

	public function index()
	{
		return Response::json(Admin::orderBy('id','DESC')->get(),200);
	}

	public function add()
	{
		$admin = new Admin;
		if(!$admin->saveAdmin()) return Response::json('Error : Could not create new admin',500);

		$user = new User;
		$user->first_name = $admin->first_name;
		$user->last_name = $admin->last_name;
		$user->email = $admin->email;
		$user->password = $admin->password;
		$user->role = 'admin';
		$user->source_id = $admin->id;
		$user->save();

		return Response::json($admin->id,200);
	}

	public function edit($id)
	{
		$admin = Admin::find($id);
		if(!$admin) return Response::json('Error : admin could not be found',404);
		if(!$admin->saveAdmin()) return Response::json('Error : Could not create new admin',500);

		//update admin data in the users table
		$user = User::Where('source_id','=',$id)->where('role','=','admin')->first();
		$user->email = Input::get('email');
		if(Input::get('password')) $user->password = Hash::make(Input::get('password'));
		$user->save();

		return Response::json('Admin information has been edited successfully',200);	
	}

	public function delete($id)
	{
		$admin = Admin::find($id);
		if(!$admin) return Response::json('Error : Admin has not been found',404);
		$user_id = $admin->source_id;
		if(!$admin->delete()) return Response::json('Error : Failedto delete admin',500);
		return Response::json('Admin has been delete successfully',200);
		
	}

}
