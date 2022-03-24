<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    use ApiResponser;

    public function register(Request $request)
    {
        $attr = $request->validate([
            'name' => 'required',
            'phone' => 'required',
            'email' => 'required|unique:users',
            'password' => 'required'
        ]);


        $user = User::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'password' => bcrypt($request->password),
            'email' => $request->email,
           
        ]);

        if (!Auth::attempt($attr)) {
            return $this->error('Credentials not match', 401);
        }
        // get the user
        $authuser = Auth::user();
        return $this->success([
            'token' => $user->createToken('API Token')->plainTextToken,
            'user' => $authuser,
            'message'=>'Successfully Registered'
        ]);
    }

    public function login(Request $request)
    {


        $request->headers->set("Accept", "application/json");
        if(Auth::attempt(['phone' => request('phone'), 'password' => request('password')])
        ||Auth::attempt(['email' => request('email'), 'password' => request('password')])){
            // do something ...
            $user = Auth::user();

            return $this->success([
                'token' => auth()->user()->createToken('API Token')->plainTextToken,
                'user' => $user
            ]);
        }else{
            return $this->error('Credentials not match', 401);
        }


//         if (!Auth::attempt($attr)) {
//             return $this->error('Credentials not match', 401);
//         }
//  // get the user
//         $user = Auth::user();

//         return $this->success([
//             'token' => auth()->user()->createToken('API Token')->plainTextToken,
//             'user' => $user
//         ]);
    }

    public function logout()
    {
        auth()->user()->tokens()->delete();

        return [
            'message' => 'Tokens Revoked'
        ];
    }
}
