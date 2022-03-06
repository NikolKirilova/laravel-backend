<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

use App\Models\User;

class AuthenticationController extends Controller
{
     //this method adds new users
     public function register(Request $request)
     {
        $fields = $request->validate([
             'name' => 'required|string|max:255',
             'email' => 'required|string|email|unique:users,email',
             'password' => 'required|string|min:6|confirmed'
         ]);
 
         $user = User::create([
             'name' => $fields['name'],
             'password' => bcrypt($fields['password']),
             'email' => $fields['email']
         ]);
 
         $token = $user->createToken('tokens')->plainTextToken;

         $response = [
            'user' => $user,
            'token' => $token
        ];

        return response($response, 201);
     }
     //use this method to signin users
     public function login(Request $request)
     {
        $fields = $request->validate([
          
            'email' => 'required|string',
            'password' => 'required|string'
        ]);

        //Check email
        $user = User::where('email', $fields['email'])->first();

        //Check password
        if(!$user || !Hash::check($fields['password'], $user->password)){
            return response ([
                'message' => 'Bad creds'
            ], 401);
        }
          

        $token = $user->createToken('myapptoken')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];

        return response($response, 201);
     }
 
     // this method signs out users by removing tokens
     public function logout(Request $request)
     {
         auth()->user()->tokens()->delete();
 
         return [
             'message' => 'Logged out'
         ];
     }
     public function getuser($id) {
        $user = User::find($id);
        
        return $user;      
    }
}
