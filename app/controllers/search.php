<?php

/**
* Search
*/
class search extends \BaseController
{
	public function subscriberSerialNumber($serial_number = false)
	{
		if(!$serial_number) return Response::json('sreial number has not been provided',500);
		$subscriber = DB::select('SELECT id,first_name,last_name,birthdate,gender,img_link FROM subscribers WHERE serial_number = "'.$serial_number.'"');
		if(!$subscriber) return Response::json('Subscriber has not been found',404);
		$visits = DB::select('SELECT subscribers.id,subscribers.first_name,subscribers.last_name,subscribers.birthdate,subscribers.gender,subscribers.img_link,visits.case,visits.treatment,visits.created_at  FROM visits,subscribers WHERE subscribers.id = visits.subscriber_id AND subscribers.serial_number = "'.$serial_number.'" ORDER BY visits.id DESC');
		if(!$visits) return Response::json($subscriber,200);
		return Response::json($visits,200);
	}

}