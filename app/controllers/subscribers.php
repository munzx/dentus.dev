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
		$subscriber->save();

		$user = new User;
		$user->first_name = $subscriber->first_name;
		$user->last_name = $subscriber->last_name;
		$user->email = $subscriber->email;
		$user->password = $subscriber->password;
		$user->role = 'subscriber';
		$user->source_id = $subscriber->id;
		$user->serial_number = $subscriber->serial_number;
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
		if(Input::get('password')) $user->password = Hash::make(Input::get('password'));
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

		$subscriberAllInfo = DB::select('SELECT s.*, c.name AS clinic_name,c.email AS clinic_email,c.phone_number AS clinic_phone_number,c.city AS clinic_city,c.address AS clinic_address,c.description AS clinic_description,c.logo_link AS clinic_logo_link,c.pic_link AS clinic_pic_link, v.case, v.treatment,v.cost,v.created_at AS visit_date
			 FROM subscribers s 
			 LEFT JOIN visits v ON v.subscriber_id = s.id 
			 LEFT JOIN clinics c ON v.clinic_id = c.id 
			 WHERE s.id = '.Auth::user()->source_id.' 
			 ORDER BY v.id DESC');

		if(!$subscriberAllInfo) return Response::json([$subscriber],200);
		return Response::json($subscriberAllInfo,200);
	}

	public function getUserInfo($id)
	{
		$subscriber = DB::select('SELECT s.*, c.name AS clinic_name,c.email AS clinic_email,c.phone_number AS clinic_phone_number,c.city AS clinic_city,c.address AS clinic_address,c.description AS clinic_description,c.logo_link AS clinic_logo_link,c.pic_link AS clinic_pic_link, v.case, v.treatment,v.cost,v.created_at AS visit_date
			 FROM subscribers s 
			 LEFT JOIN visits v ON v.subscriber_id = s.id 
			 LEFT JOIN clinics c ON v.clinic_id = c.id 
			 WHERE s.id = '.$id.' 
			 ORDER BY v.id DESC');

		if(!$subscriber) return Response::json('Subscriber has not been found',404);
		return Response::json($subscriber,200);	
	}


}
