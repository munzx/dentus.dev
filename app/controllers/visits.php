<?php

/**
* visits
*/
class visits extends \BaseController
{
	public function index()
	{
		$result = DB::select('SELECT visits.id,subscribers.first_name,subscribers.last_name,clinics.name,visits.case,visits.cost,visits.created_at FROM visits,subscribers,clinics WHERE visits.subscriber_id = subscribers.id AND visits.clinic_id = clinics.id ORDER BY visits.id DESC;');
		return Response::json($result,200);
	}

	public function delete($id)
	{
		$visit = Visit::find($id);
		if(!$visit) return Response::json('Could not find the visit details',404);
		if($visit->delete()) return Response::json('Visit has been deleted successfully',200);
		return Response::json('Error has been occured while trying to delete the visit',500);
	}

	public function add()
	{
		$visit = new Visit;
		if(!$visit->saveVisit()) return Response::json('Error : Visit could not be saved',500);
		return Response::json($visit,200);
	}

	public function clinics($id)
	{
		$result = DB::select('SELECT subscribers.id,subscribers.first_name,subscribers.last_name,subscribers.img_link,subscribers.birthdate,visits.created_at,visits.cost,visits.case,visits.treatment FROM subscribers,visits,clinics where subscribers.active = "true" AND subscribers.id = visits.subscriber_id AND visits.clinic_id = clinics.id AND visits.clinic_id '.$id.' ORDER BY visits.id DESC');
		return Response::json($result,200);
	}

	public function clinicOwnVisit()
	{
		$result = DB::select('SELECT clinics.logo_link as clinic_logo,clinics.pic_link as clinic_pic,subscribers.id,subscribers.first_name,subscribers.last_name,subscribers.img_link,subscribers.birthdate,visits.created_at,visits.cost,visits.case,visits.treatment FROM subscribers,visits,clinics where subscribers.active = "true" AND subscribers.id = visits.subscriber_id AND visits.clinic_id = clinics.id AND visits.clinic_id = '.Auth::user()->source_id.' ORDER BY visits.id DESC');
		return Response::json($result,200);
	}

	public function users($id)
	{
		return Response::json(true,200);
	}


}