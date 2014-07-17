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
Route::get('admins',['before'=>'admin','uses'=> 'admins@index']);
Route::post('admins/add',['before'=>'admin','uses'=>'admins@add']);
Route::post('admins/{id}/edit',['before'=>'admin','uses'=>'admins@edit']);
Route::get('admins/{id}/delete',['before'=>'admin','uses'=>'admins@delete']);

//Users
Route::get('users',['before'=>'admin','uses'=>'users@index']);

//Subscribers
Route::get('subscribers',['before'=>'subscriber','uses'=>'subscribers@index']);
Route::post('subscribers/add',['before'=>'subscriber','uses'=>'subscribers@add']);
Route::post('subscribers/{id}/update',['before'=>'subscriber','uses'=>'subscribers@update']);
Route::get('subscribers/{id}/delete',['before'=>'subscriber','uses'=>'subscribers@delete']);
Route::get('subscribers/{id}/visits',['before'=>'subscriber','uses'=>'visits@users']);
//to get the subscriber info through the subscriber id in the users table
Route::get('subscribers/myinfo',['before'=>'subscriber','uses'=>'subscribers@getMyInfo']);
Route::get('subscribers/{id}',['before'=>'subscriber','uses'=>'subscribers@getUserInfo']);

//Clinics
Route::get('clinics',['before'=>'clinic','uses'=>'clinics@index']);
Route::post('clinics/add',['before'=>'clinic','uses'=>'clinics@add']);
Route::post('clinics/{id}/update',['before'=>'clinic','uses'=>'clinics@update']);
Route::get('clinics/{id}/delete',['before'=>'clinic','uses'=>'clinics@delete']);
Route::get('clinics/{id}/visits',['before'=>'clinic','uses'=>'visits@clinics']);
//to get the clinic's visits via the clinic id in the 'users' table
Route::get('clinics/myvisits',['before'=>'clinic','uses'=>'visits@clinicOwnVisit']);

//Visits
Route::get('visits',['before'=>'clinic','uses'=>'visits@index']);
Route::get('visits/{id}/delete',['before'=>'clinic','uses'=>'visits@delete']);
Route::post('visits/add',['before'=>'clinic','uses'=>'visits@add']);

//Search
Route::get('search/subscribers/{serial_number}',['before'=>'clinic','uses'=>'search@subscriberSerialNumber']);