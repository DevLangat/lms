<?php

namespace App\Http\Controllers;

use App\Models\LoanRepayment;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class LoanRepaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('members.Post_repayments');
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
        
      
            $loan = new LoanRepayment();
            $loan->MemberNo = $request->MemberNo;
            $loan->Loanno = $request->Loanno;
            $loan->Active = 1;
            $loan->amount = $request->amount;
            $loan->Principal = $request->Principal;
            $loan->Interest = $request->Interest;
            $loan->ReceiptNo = $request->ReceiptNo;
            $loan->MobileNo = $request->mobileno;
            $loan->payment_status = 1;
            $loan->TransactionDate = Carbon::now()->format('Y-m-d');
            $loan->AuditTime =  Carbon::now()->format('Y-m-d');
            
            $loan->save();
            Alert::success('Loan Application', 'You\'ve Successfully Applied');
            // ['Active','MemberNo','Loanno','amount','Principal','Interest','ReceiptNo','MobileNo','payment_status','TransactionDate','AuditTime'];
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\LoanRepayment  $loanRepayment
     * @return \Illuminate\Http\Response
     */
    public function show( )
    {
        $repayments = LoanRepayment::select(
            "loan_repayments.*",             
            "members.name as Names"
        )
        ->join("members", "members.MemberNo", "=", "loan_repayments.MemberNo")
        ->where ('loan_repayments.Approved',"=",'0')
        ->get();
        return view('members.view_repayments', compact('repayments'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\LoanRepayment  $loanRepayment
     * @return \Illuminate\Http\Response
     */
    public function edit(LoanRepayment $loanRepayment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\LoanRepayment  $loanRepayment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, LoanRepayment $loanRepayment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\LoanRepayment  $loanRepayment
     * @return \Illuminate\Http\Response
     */
    public function destroy(LoanRepayment $loanRepayment)
    {
        //
    }
}
