<?php

class access extends \BaseController {

	public function check()
	{
		if(Auth::check()) return Response::json(Auth::user()->role,200);
		return Response::json(false,403);
	}

	public function login()
	{
		$usernameinput = Input::get('accessid');
		$password = Input::get('password');
		$field = filter_var($usernameinput, FILTER_VALIDATE_EMAIL) ? 'email' : 'serial_number';

		if(Auth::attempt(array($field => $usernameinput, 'password' => $password), true)) return Response::json(Auth::user()->role,200);
		return Response::json('Error : Access denied',403);
	}

	public function logout()
	{
		Auth::logout();
		return Response::json('Logged out!',200);
	}
}
