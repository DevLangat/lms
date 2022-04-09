<?php

namespace App\Http\Controllers;

use App\Models\Repayments;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
class RepaymentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('members.repayments');
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
        if (Repayments::where('ReceiptNo', '=', $request->ReceiptNo)->exists()) {
         
            Alert::error('This Receipt Number Exists in the System.'.strtoupper($request->ReceiptNo));
            return redirect()->back();
        }
      
       $repyments = new Repayments();
        $repyments->MemberNo = $request->MemberNo;
        $repyments->Loanno = $request->Loanno;
        $repyments->Active = true;
        $repyments->amount = $request->amount;
        $repyments->TransactionDate = $request->TransactionDate;
        $repyments->AuditTime = Carbon::now()->format('Y-m-d');
        $repyments->Principal = $request->Principal;
        $repyments->Interest = $request->Interest;
        $repyments->ReceiptNo = $request->ReceiptNo;
       // $repyments->Createdby = 'User';
        $repyments->MobileNo = $request->MobileNo;
        $repyments->payment_status = '1';  
        $repyments->save();
        Alert::success('Loan Repayment', 'Repayment Successfull');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Repayments  $repayments
     * @return \Illuminate\Http\Response
     */
    public function show(Repayments $repayments)
    {
        $repayments = repayments::all();
        return view('members.view_repayments',compact('repayments'));   
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Repayments  $repayments
     * @return \Illuminate\Http\Response
     */
    public function edit(Repayments $repayments)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Repayments  $repayments
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Repayments $repayments)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Repayments  $repayments
     * @return \Illuminate\Http\Response
     */
    public function destroy(Repayments $repayments)
    {
        //
    }
}
