<?php

/**
* Admins
*/
class Admin extends Eloquent
{
	protected $table = 'admins';
	protected $hidden = ['password','remmember_token'];


	public function saveAdmin()
	{
		$Rules = array(
			'first_name'=>'required|min:4',
			'last_name'=>'required|min:4',
			'email'=>'required|email'
			);

		$Validator = Validator::make(Input::all(),$Rules);


		if($Validator->fails()) return false;

		$this->first_name = Input::get('first_name');
		$this->last_name = Input::get('last_name');
		$this->email = Input::get('email');
		if(Input::get('password')) $this->password = Hash::make(Input::get('password'));

		$this->save();

		return true;
	}





}