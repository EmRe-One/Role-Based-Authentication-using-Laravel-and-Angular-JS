<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
Use App\Role;
Use App\Permission;
use App\User;
use Illuminate\Support\Facades\Input;
use JWTAuth;
use Response;
use Auth;
class AuthenticationController extends Controller
{
    //
    public function index()
    {
        $users = User::get();
        return response()->json(compact('users'));
    }

	public function register(Request $request) {
    	$credentials = Input::only('name','email', 'password');
    	$credentials['password'] = bcrypt($credentials['password']);
    	try {
     		$user = User::create($credentials);
     		if($user) {
     			$role = Role::where('name', '=', 'Guest')->first();
	    		$user->roles()->sync($role->id,false);
     		}
    	} catch (Exception $e) {
      		return Response::json(['error' => 'User already exists.'],401);
    	}
        return Response::json(compact('token'));
  	}
    public function authenticate() {
    	// grab credentials from the request
        $credentials = Input::only('email', 'password');
        try {
            // attempt to verify the credentials and create a token for the user
            if (! $token = JWTAuth::attempt($credentials)) {
                return Response::json(['error' => 'invalid_credentials'], 401);
            }
        } catch (JWTException $e) {
            // something went wrong whilst attempting to encode the token
            return Response::json(['error' => 'could_not_create_token'], 500);
        }
        // all good so return the token
        return Response::json(compact('token'));
    }
    
    public function getUserRoleAndPermissions(Request $request) {
        $user = JWTAuth::toUser($request->token);
        $role = 'Guest';
        if($user->hasRole('Owner')) {
            $role = 'owner';
        }else if($user->hasRole('Admin')){
            $role = 'Admin';
        }
        $permissions = array();
        $permissions['R'] = $user->can('R');
        $permissions['W'] = $user->can('W');
        $permissions['X'] = $user->can('X');
        $permissions['create-users'] = $user->can('create-users');
        return Response::json(compact(['role','permissions']));
    }

    public function createRole(Request $request){
	    $role = new Role();
	    $role->name = $request->input('name');
	    $role->display_name = $request->input('display_name');
	    $role->description = $request->input('description');
	    $role->save();
	    return response()->json("created");      
	}

	public function createPermission(Request $request){
	    $viewUsers = new Permission();
	    $viewUsers->name = $request->input('name');
	    $viewUsers->display_name = $request->input('display_name');
	    $viewUsers->description = $request->input('description');
	    $viewUsers->save();
	    return response()->json("created");   
	}


	public function assignRole(Request $request){
	    $user = User::where('email', '=', $request->input('email'))->first();
	    $role = Role::where('name', '=', $request->input('role'))->first();
	    $user->attachRole($request->input('role'));
	    $user->roles()->attach($role->id);
	    return response()->json("created");
	}

	public function attachPermission(Request $request){
	    $role = Role::where('name', '=', $request->input('role'))->first();
	    $permission = Permission::where('name', '=', $request->input('name'))->first();
	    $role->attachPermission($permission);
	    return response()->json("created");     
	}

	public function getToken(Request $request) {
		$token = $request->token;
		if(!$token['token']){
			return Response::json(false, HttpResponse::HTTP_UNAUTHORIZED);
		}
		try {
			$token = JWTAuth::refresh($token['token']);
			return Response::json(compact('token'));
		}catch(JWTException $e){
			return Response::json(['error' => 'Something went wrong'],500);
		}
	}
}
