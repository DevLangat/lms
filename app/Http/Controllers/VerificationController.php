<?php

namespace App\Http\Controllers;

use App\Models\Verification;
use App\Models\SMS;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

class VerificationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function verifyOtp(Request $request )
    {
        $enteredOtp = $request->OTP;
        $phone = $request->phone;
        $id = $request->id;
      
        $db = Verification::where('phone',$phone)->select('otp')->first();
        $OTP=$db->otp;
        Log::info($OTP);
        Log::info($enteredOtp);
        if($OTP == $enteredOtp){

            // Updating user's status "isVerified" as 1.

            User::where('id', $id)->update(['isVerified' => 1, 'phone_verified_at'=> Carbon::now()]);
            Log::info('In');
            Log::info($OTP);
            //Removing from d variable
            Verification::where('phone',$phone)->delete();
           
            return  response()->json([
                'success' => true,
                'message'=>'Verified.'

            ]) ; 
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendOtp(Request $request)
    {
       
        $phone=$request->phone;
        Log::info($phone);
        $otp = rand(100000, 999999);
        $message='Never share this code with anyone,use code '.$otp.' to verify your Phone number. Vanlin Investments ltd';
        Session::put('OTP', $otp);                                     
              $createsms=new SMS;
              $createsms->phone =$phone;
              $createsms->message =$message;
              $createsms->rType ='json';
              $createsms->status =0;
              $createsms->save();
              SMS::Sendsms();
        Verification::insert([
            'phone'=> $phone,
            'otp'=>$otp,
           
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function check($id)
    {
        $verification=User::find($id);
        return response()->json([
            'verification'=>$verification->isVerified
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Verification  $verification
     * @return \Illuminate\Http\Response
     */
    public function show(Verification $verification)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Verification  $verification
     * @return \Illuminate\Http\Response
     */
    public function edit(Verification $verification)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Verification  $verification
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Verification $verification)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Verification  $verification
     * @return \Illuminate\Http\Response
     */
    public function destroy(Verification $verification)
    {
        //
    }
}
