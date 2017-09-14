<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::group(['middleware'=>['web']],function(){
	
	// API route group that we need to protect
	Route::group(['api/prefix' => 'api', 'middleware' => ['ability:Owner,create-users']], function()
	{
	    // Protected route
	    Route::get('api/users', 'AuthenticationController@index');
	    // Route to create a new role
		Route::post('api/role', 'AuthenticationController@createRole');
		// Route to create a new permission
		Route::post('api/permission', 'AuthenticationController@createPermission');
		// Route to assign role to user
		Route::post('api/assign-role', 'AuthenticationController@assignRole');
		// Route to attache permission to a role
		Route::post('api/attach-permission', 'AuthenticationController@attachPermission');
	});
	Route::get('api/user/permission/{token}','AuthenticationController@getUserRoleAndPermissions');
	// Authentication route
	Route::post('api/authenticate', 'AuthenticationController@authenticate');
	Route::post('api/register', 'AuthenticationController@register');
	Route::get('api/refresh/{token}', 'AuthenticationController@getToken');
	Route::get('/', function () {
	    return view('index');
	});
	Route::any('{any}',function(){
		return view('index');
	})->where('any','.*');
});