<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\LoanApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth; 
use Illuminate\Support\Carbon; 
use App\Traits\ApiResponser;
class ApiController extends Controller
{
    use ApiResponser;
    public function membersdetails($memberno){
      
        $member = Member::where('MemberNo',$memberno)->first();
        Log::info($member);    
        $loan = Member::select(
            "members.*",             
            "loan_applications.*"
        )
        ->join("loan_applications", "members.MemberNo", "=", "loan_applications.MemberNo")
        ->where('members.MemberNo',"=",$memberno)->first()
        ; 
         
        Log::info($loan);
       // foreach($loans as $loan)
        Log::info($loan); 

       if($loan){
        return response()->json(
            [
                'success' => true,
                'member' => $member,
                'loan'=> $loan
            ]
        );
       }else{
        return response()->json(
            [
                'success' => true,
                'member' => $member,
                
            ]
        );
       }
      

    }
    public function store(Request $request)
    {
        $userid = $request->MemberNo;
        // if (LoanApplication::where('MemberNo', '=', $request->IdNumber)->exists()) {
        // }
        $count =  DB::table('loan_applications')
            ->select(DB::raw('count(*) as count'))
            ->where('MemberNo', $userid)
            ->where('LoanCode', '=', $request->LoanCode)
            ->get();
        if ($count) {
            foreach ($count as $loan_count) {
                $newcount = $loan_count->count + 1;
                $loan_number = $request->LoanCode . $userid . '-' . $newcount;
                Log::info($loan_number);
            }
        }

        $Rperiod = $request->Rperiod;
        //$loanlimit = ($deposit) * 3;
        $loanlimit=$request->LoanLimit;
        Log::info($Rperiod);
        Log::info($loanlimit);
       
        $loanapplied = $request->AmountApplied;
       
            $loan = new LoanApplication;
            $loan->MemberNo = $userid;
            $loan->Loanno = $loan_number;
            $loan->LoanCode = $request->LoanCode;
            $loan->AmountApplied = $request->AmountApplied;
            $loan->ApplicationDate = Carbon::now()->format('Y-m-d');;
            $loan->EffectDate = Carbon::now()->format('Y-m-d');
            $loan->RecoverInterestFirst = true;
            $loan->IntRate = $request->IntRate;
            $loan->Rperiod = $request->Rperiod;
            $loan->Createdby = $request->Name;
            $loan->Approved = false;
            $loan->ApprovedAmount = '0';
            $loan->RepayAmount = '0';
            $loan->IsDisbursed = false;
            $loan->ApprovedBy = $request->ApprovedBy;
            $loan->Modifiedby = $request->Modifiedby;
            $loan->ApprovedOn = $request->ApprovedOn;
            $loan->save();
            return $this->success([               
                'loan' => $loan,
                'message'=>'Successfully Applied'
            ]);
       
       
    }
}
