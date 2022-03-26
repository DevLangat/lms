<?php

namespace App\Http\Controllers;

use App\Models\Deposits;
use App\Models\LoanApplication;
use App\Models\LoanType;
use App\Models\Member;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

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
        return view('members.loanapplication', compact('loantypes'));
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
        if ($count) {
            foreach ($count as $loan_count) {
                $newcount = $loan_count->count + 1;
                $loan_number = $request->LoanCode . $userid . '-' . $newcount;
                Log::info($loan_number);
            }
        }

        $deposit = $request->Deposits;
        $loanlimit = ($deposit) * 3;
        $loanapplied = $request->AmountApplied;
        if ($loanapplied > $loanlimit) {
            Alert::error('Loan Limit', 'Your Loan Limit is: ' . strtoupper($loanlimit) . ' ' . '');
        } else {
            $loan = new LoanApplication;
            $loan->MemberNo = $userid;
            $loan->Loanno = $loan_number;
            $loan->LoanCode = $request->LoanCode;
            $loan->AmountApplied = $request->AmountApplied;
            $loan->ApplicationDate =Carbon::now()->format('Y-m-d');;
            $loan->EffectDate = Carbon::now()->format('Y-m-d');
            $loan->RecoverInterestFirst = true;
            $loan->IntRate = $request->IntRate;
            $loan->Rperiod = $request->Rperiod;
            $loan->Createdby = 'User';
            $loan->Approved = false;
            $loan->ApprovedAmount = '0';
            $loan->RepayAmount = '0';
            $loan->IsDisbursed = false;
            $loan->ApprovedBy = $request->ApprovedBy;
            $loan->Modifiedby = $request->Modifiedby;
            $loan->ApprovedOn = $request->ApprovedOn;
            $loan->save();



            Alert::success('Loan Application', 'You\'ve Successfully Applied');
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
        $showloans=LoanApplication::all();
        return view('members.view_loanApplications',compact('showloans'));
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

                $maxlimit = ($deposit->Deposits) * 3;
            }

            foreach ($members as $member) {
                Log::info($member->Name);
                Log::info($maxlimit);
                if(empty($deposit->Deposits)){
                  
                return response()->json([
                    'member' => $member,
                    'loanlimit' => 0,
                    'deposit' => 0
                ]);  
                }

                return response()->json([
                    'member' => $member,
                    'loanlimit' => $maxlimit,
                    'deposit' => $deposit->Deposits
                ]);
            }
        }  else {
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
    public function Approve(Request $request, LoanApplication $loanApplication)
    {
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\LoanApplication  $loanApplication
     * @return \Illuminate\Http\Response
     */
    public function destroy(LoanApplication $loanApplication)
    {
        //
    }
}


//Max loan amount add (deposits*3)
//check if loan applied==maxloanamount
//sum of deposits
