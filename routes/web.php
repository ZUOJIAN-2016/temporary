<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

/*
$app->get('/', function () use ($app) {
    return $app->version();
});
*/

// 用户登陆、身份认证
$app->post('/login', ['uses' => 'UserController@login']);
$app->get('/logout', ['uses' => 'UserController@logout']);
$app->post('/users', ['uses' => 'UserController@create']);


// 以下为需要登录才能够访问的 uri
$app->group(['middleware' => 'auth'], function () use ($app) {
    // 用户系统
	$app->get('/current/user', ['uses' => 'UserController@profile']);
	$app->patch('/current/user', ['uses' => 'UserController@edit']);
	$app->get('/users/{login_name}', ['uses' => 'UserController@view']);

    // 组织系统
	$app->post('/organizations', ['uses' => 'OrganizationController@create']);
	$app->get('/organizations', ['uses' => 'OrganizationController@showList']);
	$app->get('/organization/{id}', ['uses' => 'OrganizationController@view']);
	$app->get('/organization/{id}/members', ['uses' => 'OrganizationController@members']);
	$app->get('/organization/{id}/structure', ['uses' => 'OrganizationController@structure']);
    $app->patch('/organization/{id}',['uses'=>'OrganizationController@information']);


    // 活动系统
    $app->post('/activities',['uses'=>'ActivityController@draft']);
   $app->get('/activities',['uses'=>'RelationsController@activity_list']);
    $app->get('/activity/{id}/suggestion',['uses'=>'ActivityController@suggestion']);
    $app->get('/activity/{id}',['uses'=>'ActivityController@information']);
    $app->patch('/activity/{id}',['uses'=>'ActivityController@edit_information']);
});

