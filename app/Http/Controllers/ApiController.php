<?php

namespace App\Http\Controllers;

use App\Models\Deposits;
use App\Models\SMS;
use App\Models\Member;
use App\Models\LoanInterest;
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
    public function membersdetails($memberno)
    {

        $member = Member::where('MemberNo', $memberno)->first();
        Log::info($member);
        $loan = Member::select(
            "members.*",
            "loan_applications.*"
        )
            ->join("loan_applications", "members.MemberNo", "=", "loan_applications.MemberNo")
            ->where('members.MemberNo', "=", $memberno)->first();

        Log::info($loan);
        // foreach($loans as $loan)
        Log::info($loan);

        if ($loan) {
            return response()->json(
                [
                    'success' => true,
                    'member' => $member,
                    'loan' => $loan
                ]
            );
        } else {
            return response()->json(
                [
                    'success' => true,
                    'member' => $member,

                ]
            );
        }
    }
    public function loandetails($memberno){
        
        $loanlimiamt = DB::table('members')->where('MemberNo', $memberno)->pluck('MaxLoan') ->sum();
      
        $amount = DB::table('loan_applications')->where('MemberNo', $memberno)->pluck('ApprovedAmount') ->sum();
        $deposit = DB::table('deposits')->where('MemberNo', $memberno)->pluck('Amount') ->sum();
        $payment = DB::table('repayments')->where('MemberNo', $memberno)->pluck('amount') ->sum();
        $balance = $amount - $payment;

        Log::info("Loan Details");
        Log::info($balance);
        Log::info($loanlimiamt);

        return response()->json(
            [
                'success' => true,
                'loanbalance' => $balance,
                'loanlimit'=>$loanlimiamt,
                'deposit'=>$deposit
                
            ]
        );
       
       
      

    }
    public function getAllDetails(){
        $date=Carbon::now()->format('Y-m-d');
        $count_member = Member::all()->count();
        $count_loans = LoanApplication::all()->count();
        $count_pendingloans = LoanApplication::all()
        ->where ('Approved',"=",'0')
        ->count();
        $count_approvedloans = LoanApplication::all()
        ->where ('Approved',"=",'1')
        ->count();
        $count_rejectedloans = LoanApplication::all()
        ->where ('Approved',"=",'2')
        ->count();
        $sum_deposits = Deposits::all()->sum();
        $count_todayapproveloans = LoanApplication::all()
        ->where ('Approved',"=",'1')
        ->where('ApprovedOn','=',$date)
        ->count();
        Log::info($count_todayapproveloans);
        return response()->json(
            [
                'success' => true,
                'count_member' => $count_member,
                'count_loans'=>$count_loans,
                'sum_deposits'=>$sum_deposits,
                'count_pendingloans'=>$count_pendingloans,
                'count_approvedloans'=>$count_approvedloans,
                'count_rejectedloans'=>$count_rejectedloans,
                'count_todayapproveloans'=>$count_todayapproveloans,
                
            ]
        );
       
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
        // $loans_check = LoanApplication::select('*')
        //     ->where('MemberNo', $userid)
        //     ->where('Approved', 0)
        //     ->get();
        // if ($loans_check) {
        //     foreach ($loans_check as $loan_checks) {
        //         $Pendingapproval = $loan_checks->AmountApplied;
        //         if ($Pendingapproval > 0) {
                   
        //             return $this->success([                        
        //                 'message' => 'Loan Pending Approval'
        //             ]);
                   
        //         }
        //     }
           
            
        // }
        // else
        // {
        // $loanlimiamt = DB::table('members')->where('MemberNo', $userid)->pluck('MaxLoan')->sum();
        // $amount = DB::table('loan_applications')->where('MemberNo', $userid)->pluck('ApprovedAmount')->sum();
        // // $amountpendingapproval = DB::table('loan_applications')->where('MemberNo', $userid)->pluck('AmountApplied')->sum();
        // $payment = DB::table('repayments')->where('MemberNo', $userid)->pluck('amount')->sum();
        // $balance = $amount - $payment;
        // $balance = $ApprovedAmount-$RepaidAmount;
        // Log::info($payment);
        // Log::info($amount);
        // Log::info($balance);
        $zero = 0;

        // if ($balance > 0) {
        //     Alert::error('Loan Balance', 'Your Have Pending Loans: ' . strtoupper($balance) . ' ' . '');
        //     Log::info($balance);
        //     redirect()->back();
        // }

        $Rperiod = $request->Rperiod;
        //$loanlimit = ($deposit) * 3;
        $loanlimit = $request->LoanLimit;
        Log::info($Rperiod);
        Log::info($loanlimit);

       

        $loan = new LoanApplication;
        $loan->MemberNo = $userid;
        $loan->Loanno = $loan_number;
        $loan->LoanCode = $request->LoanCode;
        $loan->AmountApplied = $request->AmountApplied;
        $loanApplied = $request->AmountApplied;
        $loan->ApplicationDate = Carbon::now()->format('Y-m-d');
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
     
    
        $members_check = Member::select('*')->where('MemberNo', $userid)->get();
        foreach ($members_check as $members_checks) {
            $phone = $members_checks->KinMobile;
            $clientnames = $members_checks->Name;
            $Names = $members_checks->KinName;
            $message = 'Dear ' . $Names . ',' . $clientnames . ' has applied for a loan of KES:' . $loanApplied . ' at Vanlin Investments ltd and Choosen you as Next of Kin, regards Vanlin.0710418966';
            Log::info($Names);
            Log::info($phone);

            $createsms = new SMS;
            $createsms->phone = $phone;
            $createsms->message = $message;
            $createsms->rType = 'json';
            $createsms->status = 0;
            $createsms->save();

           $smsend= SMS::Sendsms();
           if($smsend){

            return $this->success([
                'loan' => $loan,
                'message' => 'Successfully Applied'
            ]);
        }
            //  Alert::success('Loan Application', 'You\'ve Successfully Applied');
    //     }
     }
    }
    public function approve(Request $request)
    {
              
            $date = Carbon::now()->format('Y-m-d');
            Log::info($request->ApprovedAmount);
            Log::info($request->IntRate);
            Log::info($request->Rperiod);
            $loan_number = $request->Loanno;
            $repayAmount = ($request->ApprovedAmount) / $request->Rperiod;
            $interest=(($request->ApprovedAmount)*$request->IntRate)*0.01; 
           
           
            LoanApplication::where('Loanno', $loan_number)
                    ->update([
                        'Approved' => 1,
                        'ApprovedAmount' => $request->ApprovedAmount,
                        'RepayAmount' => $repayAmount,
                        'ApprovedBy' => $request->Name,
                        'ApprovedOn' => $date
                    ]);
                   // 'Loanno','MemberNo','ApprovedAmount','InterestAmount','ApprovedBy
            LoanInterest::where('Loanno', $loan_number)
                    ->updateOrCreate([
                        'Loanno'=>$loan_number,
                        'MemberNo' =>$request->MemberNo,
                        'ApprovedAmount'=>$request->ApprovedAmount,
                        'InterestAmount'=>$interest,
                        'ApprovedBy'=>$request->Name
                    ]);
                    return $this->success([                        
                        'message' => 'Successfully Approved'
                    ]);
       
    }
    public function destroy(Request $request)
    {
         
             $loan_number = $request->Loanno;        
             $date = Carbon::now()->format('Y-m-d');
                 LoanApplication::where('Loanno', $loan_number)
                     ->update([
                         'Approved' => 2,
                         'ApprovedAmount' =>0,
                         'RepayAmount' => 0,
                         'ApprovedBy' => $request->Name,
                         'ApprovedOn' => $date
                     ]);
                    
                 
                     return $this->success([                        
                        'message' => 'Successfully Rejected'
                    ]);
          
    }
}

