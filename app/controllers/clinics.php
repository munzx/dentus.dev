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

		return Response::json('New clinic has been added successfully',200);
	}

	public function edit($id)
	{
		$clinic = Clinic::find($id);
		if(!$clinic) return Response::json('Error : Clinic has not been found',404);
		if($clinic->saveClinic()) return Response::json('New clinic has been added successfully',200);
		return Response::json('Error : Failed to add new clinic',500);
	}

	public function delete($id)
	{
		$clinic = Clinic::find($id);
		if(!$clinic) return Response::json('Error : Clinic has not been found',404);
		if($clinic->delete()) return Response::json('Clinic has been deleted successfully',200);
		return Response::json('Error : Failed to delete clinic',500);
	}

}
