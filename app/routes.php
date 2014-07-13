<?php


Route::get('/', function()
{
	return Response::json('Bism Allah',200);
});

//Access
Route::post('login','access@login');
Route::get('logout','access@logout');
Route::get('check','access@check');

//Admins
Route::get('admins','admins@index');
Route::post('admins/add','admins@add');
Route::post('admins/{id}/edit','admins@edit');
Route::get('admins/{id}/delete','admins@delete');

//Users
Route::get('users','users@index');

//Subscribers
Route::get('subscribers','subscribers@index');
Route::post('subscribers/add','subscribers@add');
Route::post('subscribers/{id}/update','subscribers@update');
Route::get('subscribers/{id}/delete','subscribers@delete');
Route::get('subscribers/{id}/visits','visits@users');
//to get the subscriber info through the subscriber id in the users table
Route::get('subscribers/myinfo','subscribers@getMyInfo');
Route::get('subscribers/{id}','subscribers@getUserInfo');

//Clinics
Route::get('clinics','clinics@index');
Route::post('clinics/add','clinics@add');
Route::post('clinics/{id}/update','clinics@update');
Route::get('clinics/{id}/delete','clinics@delete');
Route::get('clinics/{id}/visits','visits@clinics');
//to get the clinic's visits via the clinic id in the 'users' table
Route::get('clinics/myvisits','visits@clinicOwnVisit');

//Visits
Route::get('visits','visits@index');
Route::get('visits/{id}/delete','visits@delete');
Route::post('visits/add','visits@add');

//Search
Route::get('search/subscribers/{serial_number}','search@subscriberSerialNumber');


//test posts
Route::post('test','test@index');