<?php

namespace App\Http\Controllers;

use App\Models\Deposits;
use App\Models\LoanApplication;
use App\Models\LoanType;
use App\Models\Member;
use App\Models\LoanInterest;
use App\Models\Repayments;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\SMS;
class LoanApplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $loantypes = LoanType::all();
        return view('members.Loanapplication', compact('loantypes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
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

            $loanlimiamt = DB::table('members')->where('MemberNo', $userid)->pluck('MaxLoan') ->sum();
            $amount = DB::table('loan_applications')->where('MemberNo', $userid)->pluck('ApprovedAmount') ->sum();
            $payment = DB::table('repayments')->where('MemberNo', $userid)->pluck('amount') ->sum();
            $balance = $amount - $payment;
            // $balance = $ApprovedAmount-$RepaidAmount;
            // Log::info($payment);
            // Log::info($amount);
            // Log::info($balance);
            $zero=0;
            
            if($balance>0)
            {              
                 Alert::error('Loan Balance', 'Your Have Pending Loans: ' .strtoupper ($balance) . ' ' . '');
                Log::info($balance);
                redirect()->back();
            }else{
                if ($count) {
                    foreach ($count as $loan_count) {
                        $newcount = $loan_count->count + 1;
                        $loan_number = $request->LoanCode . $userid . '-' . $newcount;
                        // Log::info($loan_number);
                    }
                }
        
                $Rperiod = $request->Rperiod;
                //$loanlimit = ($deposit) * 3;
                $loanlimit=$loanlimiamt;
                // Log::info($Rperiod);
                // Log::info($loanlimiamt);
               
                $loanapplied = $request->AmountApplied;
                if ($loanapplied > $loanlimit) {
                    Alert::error('Loan Limit', 'Your Loan Limit is: ' . $loanlimit . ' ' . '');
                } else {
                    $loan = new LoanApplication;
                    $loan->MemberNo = $userid;
                    $loan->Loanno = $loan_number;
                    $loan->LoanCode = $request->LoanCode;
                    $loan->AmountApplied = $request->AmountApplied;
                   $loanApplied= $request->AmountApplied;
                    $loan->ApplicationDate = Carbon::now()->format('Y-m-d');;
                    $loan->EffectDate = Carbon::now()->format('Y-m-d');
                    $loan->RecoverInterestFirst = true;
                    $loan->IntRate = $request->IntRate;
                    $loan->Rperiod = $request->Rperiod;
                    $loan->Createdby = Auth::user()->name;
                    $loan->Approved = 0;
                    $loan->ApprovedAmount = '0';
                    $loan->RepayAmount = '0';
                    $loan->IsDisbursed = false;
                    $loan->ApprovedBy = $request->ApprovedBy;
                    $loan->Modifiedby = $request->Modifiedby;
                    $loan->ApprovedOn = $request->ApprovedOn;
                    $loan->save();                      

                    $members_check = Member::select('*')->where('MemberNo', $userid)->get();
                    foreach($members_check as $members_checks)
                    {
                         $phone=$members_checks->KinMobile;
                         $clientnames=$members_checks->Name;
                         $Names=$members_checks->KinName;
                         $message='Dear '. $Names.','. $clientnames .' has applied for a loan of KES:'.$loanApplied.' at Vanlin Investments ltd,regards Vanlin.0710418966';
                         Log::info($Names);
                         Log::info($phone);
                         
              $createsms=new SMS;
              $createsms->phone =$phone;
              $createsms->message =$message;
              $createsms->rType ='json';
              $createsms->status =0;
              $createsms->save();
              SMS::Sendsms();
                         Alert::success('Loan Application', 'You\'ve Successfully Applied');
                      }
                  }
                    
                    // $phone = DB::table('members')->where('MemberNo', $userid)->pluck('KinMobile'); 
                    // $clientnames = DB::table('members')->where('MemberNo', $userid)->pluck('Name');   
                    //  $Names = DB::table('members')->where('MemberNo', $userid)->pluck('KinName') ;      
                    

                }
        
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\LoanApplication  $loanApplication
     * @return \Illuminate\Http\Response
     */
    public function show()
    {        
        



        // if ($request->from_date && $request->to_date) {
        //     $now = $request->from_date;
        //     $to = $request->to_date;
        //     $sales = Sales::join('products', 'sales.ProductCode', '=', 'products.ProductCode')
        //         ->where('SalesDate', '>=', $now)
        //         ->where('SalesDate', '<=', $to)
        //         ->get(['sales.*', 'products.Productname']);
        //     $result = DB::table('sales')
        //         ->join('products', 'sales.ProductCode', '=', 'products.ProductCode')
        //         ->select(DB::raw('SUM(Amount) as total'))
        //         ->where('SalesDate', '>=', $now)
        //         ->where('SalesDate', '<=', $to)
        //         ->get();

        //     return view('admin.sales', compact('sales', 'result'));
        // } else {

            $showloans = LoanApplication::select(
                "loan_applications.*",             
                "members.name as Names"
            )
            ->join("members", "members.MemberNo", "=", "loan_applications.MemberNo")
            ->where ('loan_applications.Approved',"=",'0')
            ->get();
            if($showloans){
                
                Log::info($showloans);
                return response()->json(
                    [
                        'loans' => $showloans,                      
                    ]
                ); 
            }

            $loanapplied = DB::table('loan_applications')                
                ->select(DB::raw('SUM(AmountApplied) as total'))
                ->where ('loan_applications.Approved',"=",'0')
                ->get();
            return view('members.view_loanApplications', compact('showloans','loanapplied'));
        // }
    }
    public function showApproved()
    {        
        $showloans = LoanApplication::select(
            "loan_applications.*",             
            "members.name as Names"
        )
        ->join("members", "members.MemberNo", "=", "loan_applications.MemberNo")
        ->where ('loan_applications.Approved',"=",'1')
        ->get();
        return view('members.view_loansapproved', compact('showloans'));
    }
    public function showRejectedloans()
    {        
        $showloans = LoanApplication::select(
            "loan_applications.*",             
            "members.name as Names"
        )
        ->join("members", "members.MemberNo", "=", "loan_applications.MemberNo")
        ->where ('loan_applications.Approved',"=",'2')
        ->get();
        return view('members.view_loansrejected', compact('showloans'));
    }

    public function getUserbyid(Request $request)
    {
        $userid = $request->userid;

        $members_check = Member::select('*')->where('MemberNo', $userid)->get();
        if ($members_check) {
            // Fetch all records           
            $members = Member::select('*')
                ->where('MemberNo', $userid)
                ->get();
                

            $deposits = Deposits::select(DB::raw('SUM(Amount) as Deposits'))
                ->where('MemberNo', $userid)
                ->get();


            foreach ($deposits as $deposit) {

                // $maxlimit = ($deposit->Deposits) * 3;
            }

            foreach ($members as $member) {
                Log::info($member->Name);
                Log::info($member->MaxLoan);
                $maxlimit=$member->MaxLoan;
                if (empty($deposit->Deposits)) {

                    return response()->json([
                        'member' => $member,
                        'loanlimit' => $maxlimit,
                        'deposit' => 0
                    ]);
                }

                return response()->json([
                    'member' => $member,
                    'loanlimit' => $maxlimit,
                    'deposit' => $deposit->Deposits
                ]);
            }
        } else {
            Alert::error('No Member', 'The Member with ID No.' . strtoupper($request->userid) . ' ' . ' is not found');
        }
    }
    public function getLoantypes(Request $request)
    {

        $loancode = $request->loancode;

        $loantypes = LoanType::select('*')->where('LoanCode', $loancode)->get();
        if ($loantypes) {
            // Fetch all records
            foreach ($loantypes as $loantype)
                Log::info($loantype->Ratio);
            return response()->json([
                'loantype' => $loantype
            ]);
        } else {
            Alert::error('No Member', 'The Member with ID No.' . strtoupper($request->userid) . ' ' . ' is not found');
        }
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\LoanApplication  $loanApplication
     * @return \Illuminate\Http\Response
     */
    public function edit(LoanApplication $loanApplication)
    {
        //
    }
    public function getmember(Request $request)
    {
        Log::info($request->ID);
        if (Member::where('IdNumber', '=', $request->ID)->exists()) {

            $member = Member::all();
            return $member;
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\LoanApplication  $loanApplication
     * @return \Illuminate\Http\Response
     */
    public function approve(Request $request)
    {
        if ($request->Approved) {
           
           Alert::error('Loan Approval', 'The Loan is already Approved');
        }
         else {
            $date = Carbon::now()->format('Y-m-d');
            $loan_number = $request->Loanno;
            $repayAmount = ($request->ApprovedAmount) / $request->Rperiod;
            $interest=(($request->ApprovedAmount)*$request->IntRate)*0.01; 
            $loanApplied = $request->AmountApplied;
            $loanApproved = $request->ApprovedAmount;
            if ($loanApproved > $loanApplied) {

                Alert::error('Error', 'Approval Amount Cannot be Higher than Amount Applied');
            } else {
                LoanApplication::where('Loanno', $loan_number)
                    ->update([
                        'Approved' => 1,
                        'ApprovedAmount' => $request->ApprovedAmount,
                        'RepayAmount' => $repayAmount,
                        'ApprovedBy' => Auth::user()->name,
                        'ApprovedOn' => $request->ApprovedOn
                    ]);
                   // 'Loanno','MemberNo','ApprovedAmount','InterestAmount','ApprovedBy
                LoanInterest::where('Loanno', $loan_number)
                    ->updateOrCreate([
                        'Loanno'=>$loan_number,
                        'MemberNo' =>$request->MemberNo,
                        'ApprovedAmount'=>$request->ApprovedAmount,
                        'InterestAmount'=>$interest,
                        'ApprovedBy'=>'Kevin'
                    ]);
                
                Alert::success('Loan Approval', 'Approval Successfully');
            }
        }
         return redirect('/loans/all');
    }
    public function loan_details($id)
    {
        $showloan = LoanApplication::find($id);
        if ($showloan) {
            $members = Member::select('*')->where('MemberNo', $showloan->MemberNo)->get();
            foreach ($members as $member);
        }
        return view('members.approve_loan', compact('showloan', 'member'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\LoanApplication  $loanApplication
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
         
             $loan_number = $request->Loanno;        
             
                 LoanApplication::where('Loanno', $loan_number)
                     ->update([
                         'Approved' => 2,
                         'ApprovedAmount' =>0,
                         'RepayAmount' => 0,
                         'ApprovedBy' => Auth::user()->name,
                         'ApprovedOn' => $request->ApprovedOn
                     ]);
                    
                 
                 Alert::success('Loan Rejection', 'Rejection Done Successfully');
             
         
         return redirect('/loans/all');
    }
}


//Max loan amount add (deposits*3)
//check if loan applied==maxloanamount
//sum of deposits
