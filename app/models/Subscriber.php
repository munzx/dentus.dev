<?php

/**
* Subscriber
*/
class Subscriber extends Eloquent
{
	protected $table = 'subscribers';
	protected $hidden = ['password'];
	protected $guarded = ['password'];
	protected $uploadFolder = 'uploads';

	public function saveSubscriber()
	{
		$Rules = array(
			'first_name'=>'required',
			'last_name'=>'required',
			'nationality'=>'required',
			'birthdate'=>'required',
			'mobile_number'=>'required',
			'city'=>'required',
			'email'=>'required',
			'address'=>'required',
			'work_status'=>'required',
			'serial_number'=>'required',
			'marital_status'=>'required',
			'gender'=>'required'
			);


		$Validator = Validator::make(Input::all(),$Rules);

		if($Validator->fails()) return false;

		$this->first_name = Input::get('first_name');
		$this->last_name = Input::get('last_name');
		$this->nationality = Input::get('nationality');
		$this->birthdate = Input::get('birthdate');
		$this->mobile_number = Input::get('mobile_number');
		$this->city = Input::get('city');
		$this->address = Input::get('address');
		$this->work_status = Input::get('work_status');
		$this->marital_status = Input::get('marital_status');
		$this->childern = Input::get('childern');
		$this->company_name = Input::get('company_name');
		$this->company_city = Input::get('company_city');
		$this->company_phone = Input::get('company_phone');
		$this->email = Input::get('email');
		$this->gender = Input::get('gender');
		$this->serial_number = Input::get('serial_number');
		if(Input::get('password')) $this->password = Hash::make(Input::get('password'));
		$this->active = 'true';

		if (Input::hasFile('img_link'))
		{
			$prefix = date('y').date('m').date('d');
			$fileNewName = $prefix.Input::get('email').'.'.Input::file('img_link')->getClientOriginalExtension();
			Input::file('img_link')->move('uploads',$fileNewName);
			$this->img_link = $fileNewName;
		}

		$this->save();

		return true;
	}

}