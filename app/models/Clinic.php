<?php

/**
* Clinics
*/
class Clinic extends Eloquent
{
	protected $table = 'clinics';
	protected $hidden = ['password'];


	//save the udate and new clincs
	public function saveClinic()
	{
		$Rules = array(
			'name'=>'required',
			'email'=>'email|required',
			'phone_number'=>'required',
			'city'=>'required',
			'address'=>'required',
			);

		$Validator = Validator::make(Input::all(),$Rules);

		if($Validator->fails()) return false;

		$this->name = Input::get('name');
		$this->email = Input::get('email');
		$this->phone_number = Input::get('phone_number');
		$this->city = Input::get('city');
		$this->address = Input::get('address');
		$this->description = Input::get('description');
		$this->password = Hash::make(Input::get('password'));

		$this->save();

		return true;
	}
}