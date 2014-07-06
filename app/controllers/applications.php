<?php

class applications extends \BaseController {

	public function index()
	{
		$dump = ['one','two'];
		return Response::json($dump,200);
	}

}
