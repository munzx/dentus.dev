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

		return Response::json(['serial_number'=>$subscriber->serial_number,'id'=>$subscriber->id],200);
	}

	public function update($id)
	{
		$subscriber = Subscriber::find($id);
		if(!$subscriber) return Response::json('Error : Subscriber not found!',404);

		//delete the old image if a new image exists
		if(Input::hasFile('img_link'))
		{
			File::delete('uploads/'.$subscriber->img_link);
		}

		if(!$subscriber->saveSubscriber()) return Response::json('Error : Could not update subscriber information',500);

		//update subscriber data in the users table
		$user = User::Where('source_id','=',$id)->where('role','=','subscriber')->first();
		$user->email = Input::get('email');
		$user->password = Hash::make(Input::get('password'));
		$user->save();

		return Response::json('Subscriber has been updated successfully',200);
	}

	public function delete($id)
	{
		$subscriber = Subscriber::find($id);
		if(!$subscriber) return Response::json('Subscriber not found',404);
		$subscriber->delete();
		return Response::json('Subscriber has been deleted successfully',200);
	}

	public function getMyInfo()
	{
		$subscriber = Subscriber::find(Auth::user()->source_id);
		if(!$subscriber) return Response::json('Subscriber has not been found',404);
		$subscriberAllInfo = DB::select('SELECT subscribers.*,
			clinics.name AS clinic_name,clinics.email AS clinic_email,clinics.phone_number AS clinic_phone_number,clinics.city AS clinic_city,clinics.address AS clinic_address,clinics.description AS clinic_description,clinics.logo_link AS clinic_logo_link,clinics.pic_link AS clinic_pic_link,
			visits.case,visits.treatment,visits.cost,visits.created_at AS visit_date
			FROM subscribers,clinics,visits 
			WHERE visits.subscriber_id = subscribers.id AND visits.clinic_id = clinics.id AND subscribers.id = '.Auth::user()->source_id);
		if(!$subscriberAllInfo) return Response::json([$subscriber],200);
		return Response::json($subscriberAllInfo,200);
	}

	public function getUserInfo($id)
	{
		$subscriber = DB::select('SELECT subscribers.*,
			clinics.name AS clinic_name,clinics.email AS clinic_email,clinics.phone_number AS clinic_phone_number,clinics.city AS clinic_city,clinics.address AS clinic_address,clinics.description AS clinic_description,clinics.logo_link AS clinic_logo_link,clinics.pic_link AS clinic_pic_link,
			visits.case,visits.treatment,visits.cost,visits.created_at AS visit_date
			FROM subscribers,clinics,visits 
			WHERE visits.subscriber_id = subscribers.id AND visits.clinic_id = clinics.id AND subscribers.id = '.$id);

		if(!$subscriber) return Response::json('Subscriber has not been found',404);
		return Response::json($subscriber,200);	
	}


}
