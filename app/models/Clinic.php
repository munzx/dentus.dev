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

		if(Input::hasFile('logo_link'))
		{
			$prefix = date('y').date('m').date('d');
			$fileNewName = $prefix.Input::get('email').'.'.Input::file('logo_link')->getClientOriginalExtension();
			Input::file('logo_link')->move('uploads',$fileNewName);
			$this->logo_link = $fileNewName;
		}

		if(Input::hasFile('pic_link'))
		{
			//change the prefix date order to avoid conflict in naming
			$prefix = date('y').date('d').date('m');
			$fileNewName = $prefix.Input::get('email').'.'.Input::file('pic_link')->getClientOriginalExtension();
			Input::file('pic_link')->move('uploads',$fileNewName);
			$this->pic_link = $fileNewName;
		}

		$this->save();

		return true;
	}
}