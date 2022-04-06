<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Member;
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
            'memberno' => $request->memberno,
           
        ]);

        if (!Auth::attempt($attr)) {
            return $this->error('Credentials not match', 401,[
                'message'=>'Email already taken/registered'
            ]);
        }
        // get the user
        $authuser = Auth::user();
        if (Member::where('MemberNo', '=', $request->MemberNo)->exists()) {
            return $this->error('Credentials not match', 401,[
                'message'=>'Member already Exist'
            ]);
           
        }
        Member::create([
            'MemberNo'=> $request->memberno,
            'Name'=>$request->name,
            'Address'=>$request->address,
            'Email'=>$request->email,
            'Mobile'=>$request->phone,
            'KinName'=>$request->kinName,
            'GroupCode'=>'M_001',
            'KinMobile'=>$request->kinMobile

        ]);
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
            return $this->error('Credentials not match', 401,[
                'message'=>'Wrong username or password'
            ]);
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
