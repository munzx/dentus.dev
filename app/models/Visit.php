<?php

/**
* Visits
*/
class Visit extends Eloquent
{
	protected $table = 'visits';


	public function saveVisit()
	{
		$Rules = array(
				'subscriber_id'=>'required',
				'case'=>'required',
				'treatment'=>'required',
				'cost'=>'required'
			);

		$Validator = Validator::make(Input::all(),$Rules);

		if($Validator->fails()) return false;

		$this->subscriber_id = Input::get('subscriber_id');
		$this->clinic_id = Auth::user()->source_id;
		$this->case = Input::get('case');
		$this->treatment = Input::get('treatment');
		$this->cost = Input::get('cost');
		$this->save();

		return true;
	}

}