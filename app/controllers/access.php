<?php

class access extends \BaseController {

	public function check()
	{
		return Response::json(Auth::check(),200);
	}

	public function login()
	{
		if(Auth::attempt(['email'=>Input::get('email'),'password'=>Input::get('password')])) return Response::json(Auth::user()->role,200);
		return Response::json('Error : Access denied',403);
	}

	public function logout()
	{
		Auth::logout();
		return Response::json('Logged out!',200);
	}
}
