<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Hash;

class AuthApiController extends Controller
{
	public function __construct()
	{
	    
	}
  public function login(Request $request)
  {
      $this->validate($request, [
          'email' => 'required|email',
          'password' => 'required|between:5,25'
      ]);
      $user = User::where('email', $request->email)
          ->first();
      if($user && Hash::check($request->password, $user->password)) {
          // generate new api token
          $user->api_token = str_random(60);
          $user->save();
          return response()
              ->json([
                  'authenticated' => true,
                  'api_token' => $user->api_token,
                  'user_id' => $user->id
              ]);
      }
      return response()
          ->json([
              'email' => ['Provided email and password does not match!']
          ], 422);
  }

  public function logout(Request $request)
  {
      $user = $request->user();
      $user->api_token = null;
      $user->save();
      return response()
          ->json([
              'done' => true
          ]);
  }
}
