<?php

class clinics extends \BaseController {

	public function index()
	{
		return Response::json(Clinic::orderBy('id','DESC')->get(),200);
	}

	public function add()
	{
		$clinic = new Clinic;
		if(!$clinic->saveClinic()) return Response::json('Error : Failed to add new clinic',500);

		$user = new User;
		$user->first_name = $clinic->name;
		$user->last_name = $clinic->name;
		$user->email = $clinic->email;
		$user->password = $clinic->password;
		$user->role = 'clinic';
		$user->source_id = $clinic->id;
		$user->save();

		return Response::json($clinic->id,200);
	}

	public function update($id)
	{
		$clinic = Clinic::find($id);
		if(!$clinic) return Response::json('Error : Clinic has not been found',404);

		if(Input::hasFile('logo_link'))
		{
			File::delete($clinic->logo_link);
		}

		if(Input::hasFile('pic_link'))
		{
			File::delete($clinic->pic_link);
		}

		if(!$clinic->saveClinic()) return Response::json('Error : Failed to add new clinic',500);

		//update clinic data in the users table
		$user = User::Where('source_id','=',$id)->where('role','=','clinic')->first();
		$user->email = Input::get('email');
		if(Input::get('password')) $user->password = Hash::make(Input::get('password'));
		$user->save();

		return Response::json('New clinic has been updated successfully',200);
	}

	public function delete($id)
	{
		$clinic = Clinic::find($id);
		if(!$clinic) return Response::json('Error : Clinic has not been found',404);
		//delete clinic logo
		File::delete('uploads/'.$clinic->logo_link);
		//delete clinic profile image
		File::delete('uploads/'.$clinic->pic_link);
		if($clinic->delete()) return Response::json('Clinic has been deleted successfully',200);
		return Response::json('Error : Failed to delete clinic',500);
	}

}
