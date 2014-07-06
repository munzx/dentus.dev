<?php

class subscribers extends \BaseController {

	public function index()
	{
		return Response::json(Subscriber::orderBy('id','DESC')->get(),200);
	}

	public function add()
	{
		$subscriber = New Subscriber;
		if(!$subscriber->saveSubscriber()) return Response::json('Error adding new subscriber',500);

		$subscriber->serial_number = date('y').date('m').date('d').$subscriber->id;
		$subscriber->save();

		$user = new User;
		$user->first_name = $subscriber->first_name;
		$user->last_name = $subscriber->last_name;
		$user->email = $subscriber->email;
		$user->password = $subscriber->password;
		$user->role = 'subscriber';
		$user->source_id = $subscriber->id;
		$user->save();

		return Response::json('User has been added successfully',200);
	}

	public function update($id)
	{
		$subscriber = Subscriber::find($id);
		if(!$subscriber) return Response::json('Error : Subscriber not found!',404);
		if($subscriber->saveSubscriber()) return Response::json('Subscriber has been updated successfully',200);
		return Response::json('Error : Could not update subscriber information',404);
	}

	public function delete($id)
	{
		$subscriber = Subscriber::find($id);
		if(!$subscriber) return Response::json('Subscriber not found',404);
		$subscriber->delete();
		return Response::json('Subscriber has been deleted successfully',200);
	}

}
