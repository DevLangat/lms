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
        // Log::info($balance);
         
         if (LoanApplication::where('MemberNo',$memberno)->exists()){
            $status=DB::table('loan_applications')->select('Approved')->where('MemberNo', $memberno)->get();  
            Log::info($status);
            if (!$status==null){
                foreach($status as $loanstatus)
                    Log::info($loanstatus->Approved);
                
                return response()->json(
                    [
                        'success' => true,
                        'loanbalance' => $balance,
                        'loanlimit'=>$loanlimiamt,
                        'deposit'=>$deposit,
                        'loanstatus'=>$loanstatus->Approved
                        
                    ]
                );
            
            }
        }
           
      

        return response()->json(
            [
                'success' => true,
                'loanbalance' => $balance,
                'loanlimit'=>$loanlimiamt,
                'deposit'=>$deposit,
                'loanstatus'=>'no loan'
                
            ]
        );   
       
      

    }
    public function getmyloan($memberno){
        $myloans=LoanApplication::where('MemberNo','=',$memberno)->get();
        Log::info("May Laoys");
        return response()->json(
            [
                'success' => true,
                'loanhistory' => $myloans,                
                
            ]
        );


    }
    public function getAllLoans(){
        
        $all_loans = LoanApplication::select(
            "loan_applications.*",             
            "members.name as Names"
        )
        ->join("members", "members.MemberNo", "=", "loan_applications.MemberNo")           
        ->get();
        if($all_loans){
         
            return response()->json(
                [
                    'success'=>true,
                    'loans' => $all_loans,                      
                ]
            ); 
        }

    }
    public function getAllPendingLoans(){
        
        $pending_loans = LoanApplication::select(
            "loan_applications.*",             
            "members.name as Names"
        )
        ->join("members", "members.MemberNo", "=", "loan_applications.MemberNo")
        ->where ('loan_applications.Approved',"=",'0')
        ->get();
        if($pending_loans){
            Log::info("Pending Loans");
            Log::info($pending_loans);
            return response()->json(
                [
                    'success'=>true,
                    'loans' => $pending_loans,                      
                ]
            ); 
        }


    }
    public function getAllApprovedLoans(){
        
        $approved_loans = LoanApplication::select(
            "loan_applications.*",             
            "members.name as Names"
        )
        ->join("members", "members.MemberNo", "=", "loan_applications.MemberNo")
        ->where ('loan_applications.Approved',"=",'1')
        ->get();
        if($approved_loans){
            Log::info("Approved Loans");
            Log::info($approved_loans);
            return response()->json(
                [
                    'success'=>true,
                    'loans' => $approved_loans,                      
                ]
            ); 
        }


    }

    public function getAllRejectedLoans(){
        
        $rejected_loans = LoanApplication::select(
            "loan_applications.*",             
            "members.name as Names"
        )
        ->join("members", "members.MemberNo", "=", "loan_applications.MemberNo")
        ->where ('loan_applications.Approved',"=",'2')
        ->get();
        if($rejected_loans){
            Log::info("Rejected Loans");
            Log::info($rejected_loans);
            return response()->json(
                [
                    'success'=>true,
                    'loans' => $rejected_loans,                      
                ]
            ); 
        }


    }
    public function getAllDeposits(){
        
        $all_deposits = Deposits::select(
            "deposits.*",             
            "members.name as Names"
        )
        ->join("members", "members.MemberNo", "=", "deposits.MemberNo")        
        ->get();
        if($all_deposits){
            
            Log::info($all_deposits);
            return response()->json(
                [
                    'success'=>true,
                    'all_deposits' => $all_deposits,                      
                ]
            ); 
        }


    }
    public function getAllDetails(){
        $date=Carbon::now()->format('Y-m-d');
        $count_member = Member::all()->count();
       // $count_loans = LoanApplication::all()->count();
        $total_loans = DB::table('loan_applications')->pluck('ApprovedAmount') ->sum();
        // $deposit = DB::table('deposits')->where('MemberNo', $memberno)->pluck('Amount') ->sum();
        $total_pendingloans =DB::table('loan_applications')->where ('Approved',"=",'0')->pluck('AmountApplied')->sum();
        $total_approvedloans = DB::table('loan_applications')->where ('Approved',"=",'1')->pluck('ApprovedAmount')->sum();
        $total_rejectedloans = DB::table('loan_applications') ->where ('Approved',"=",'2')->pluck('AmountApplied') ->sum();  
        $sum_deposits = DB::table('deposits')->pluck('Amount') ->sum();
        $total_todayapproveloans = LoanApplication::all()
        ->where ('Approved',"=",'1')
        ->where('ApprovedOn','=',$date)
        ->count();
        $total_todayrejectedloans = LoanApplication::all()
        ->where ('Approved',"=",'2')
        ->where('ApprovedOn','=',$date)
        ->count();
        // Log::info($total_approvedloans);
        return response()->json(
            [
                'success' => true,
                'count_member' => $count_member,
                'total_loans'=>$total_loans,
                'sum_deposits'=>$sum_deposits,
                'total_pendingloans'=>$total_pendingloans,
                'total_approvedloans'=>$total_approvedloans,
                'total_rejectedloans'=>$total_rejectedloans,
                'total_todayapproveloans'=>$total_todayapproveloans,
                'total_todayrejectedloans'=>$total_todayrejectedloans,

                
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

