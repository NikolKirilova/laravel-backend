<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use App\Models\User;

class UserController extends Controller
{   
    protected function create(array $data)
    {
        return User::create([
            'email' => $data['email'],            
            'phone' => $data['phone'],
            'contact_person' => $data['contact_person'] ?? null,
            'first_name' => $data['first_name'] ?? null,
            'last_name' => $data['last_name'] ?? null,
            'address' => $data['address']
           
        ]);
    }
    public function update(Request $request, $id )
    {
        // DB::transaction(function() use ($request){
        //     $user = Auth::user();

        $user = User::find($id);

            $user->update([
                    'name' => $request->name,
                    'email' => $request->email,
                    'first_name' => $request->first_name,
                    'last_name' => $request->last_name,
                    'address' => $request->address,

                ]);
            
       

        return response()->json(['message' => 'User Updated'], 200);
    }
}
