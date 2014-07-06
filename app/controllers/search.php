<?php

/**
* Search
*/
class search extends \BaseController
{
	public function subscriberSerialNumber($serial_number = false)
	{
		if(!$serial_number) return Response::json('sreial number has not been provided',500);
		$visits = DB::select('SELECT subscribers.id,subscribers.first_name,subscribers.last_name,subscribers.birthdate,subscribers.gender,visits.case,visits.treatment,visits.created_at  FROM visits,subscribers WHERE subscribers.id = visits.subscriber_id AND subscribers.serial_number = '.$serial_number.' ORDER BY visits.id DESC');
		if($visits) return Response::json($visits,200);
		return Response::json('Subscriber has not been found',404);
	}

}