<?php

namespace App\Http\Controllers;
use App\Models\LoanApplication;
use App\Models\SMS;
use App\Models\Member;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Carbon;
class SMSController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //   SMS::create($request->all());
        // $this->data['phone'] =$request->phone;
        // $this->data['message'] =$request->message;
        // $this->data['rType'] =$request->rType;
        // $this->data['status'] =$request->status;
    }
    public function Savesms()
    {
        // $loans = DB::table('loan_applications')->whereNotIn('Loanno', function($q){
        //     $q->select('SNo')->from('s_m_s')
        //     ->whereNotNull('SNo');
        // })->get(['Loanno','MemberNo','EffectDate']);

  
        $loans = LoanApplication::whereNotIn('Loanno', function($q){
            $q-> select('SNo')->from('s_m_s')
            ->whereNotNull('SNo');
        })->get();
    Log::info($loans);
    foreach ($loans as $loanno) {
        Log::info($loanno);      
       $userid=$loanno->MemberNo;
        $loannumber = $loanno->Loanno;
        $Effectivedate = $loanno->EffectDate;
        $current_time = Carbon::now('Africa/Nairobi');
        $today = $current_time->toDateString();
        Log::info($loannumber);
        Log::info($today);
        Log::info($Effectivedate);
        $amount = DB::table('loan_applications')->where('Loanno', $loannumber)->pluck('ApprovedAmount')->sum();
        $payment = DB::table('repayments')->where('Loanno', $loannumber)->pluck('amount')->sum();
        $balance = $amount - $payment;
        if ($balance>0 && $Effectivedate<$today)
        {
            $members_check = Member::select('*')->where('MemberNo', $userid)->get();
            foreach($members_check as $members_checks)
            {
                 $phone=$members_checks->Mobile;
                 $clientnames=$members_checks->Name;
                 $Names=$members_checks->KinName;
            }
            $message='Dear '. $clientnames.',Your Loan Balance of KES:'.$balance.' at Vanlin Investments ltd is overDue.Please pay soon to avoid interest acrual,regards Vanlin.0710418966';
            $createsms=new SMS;
            $createsms->phone =$phone;
            $createsms->message =$message;
            $createsms->rType ='json';
            $createsms->SNo =$loannumber;
            $createsms->status =0;
            $createsms->save();         
  SMS::Sendsms();
        }
    }

      
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SMS  $sMS
     * @return \Illuminate\Http\Response
     */
    public function show(SMS $sMS)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SMS  $sMS
     * @return \Illuminate\Http\Response
     */
    public function edit(SMS $sMS)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SMS  $sMS
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SMS $sMS)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SMS  $sMS
     * @return \Illuminate\Http\Response
     */
    public function destroy(SMS $sMS)
    {
        //
    }
}
