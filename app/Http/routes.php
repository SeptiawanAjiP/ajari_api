<?php


$app->get('/{code}', 'VoucherController@get');

$app->post('login', 'UserController@login');

$app->post('dataByPhone', 'UserController@getDataPhone');

$app->post('registerPhone', 'UserController@registerPhone');

$app->post('loginMentor', 'MentorController@login');

$app->post('registerMentor', 'MentorController@register');

$app->get('sendMessage', 'AuthController@sendMessage');



$app->group(['middleware' => 'auth:api'], function() use ($app){

		$app->post('uploadFoto', 'UserController@uploadFoto');

		$app->post('userPoin', 'UserController@userPoin');

		$app->post('uploadFotoMentor', 'MentorController@uploadFoto');

		$app->post('formField', 'AjariController@formField');
		
		$app->post('price', 'BookingController@price');

		$app->post('formBook', 'BookingController@formBook');

		$app->post('terimaBook', 'BookingController@terimaBook');

		$app->post('batalBook', 'BookingController@batalBook');

		$app->post('listBook',  'BookingController@listBook');

		$app->post('listHistoryBook', 'BookingController@listHistoryBook');
		
	
});
