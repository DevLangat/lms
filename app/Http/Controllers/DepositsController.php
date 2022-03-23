<?php

namespace App\Http\Controllers;

use App\Models\Deposits;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\DB;
class DepositsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
            return view('members.Deposits');
       
         
    }
    public function getdeposits()
    {
        $countries = DB::table('deposit_types')->pluck("SharesName","SharesCode");
        return view('dropdown',compact('deposits'));
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
        if (Deposits::where('ReceiptNo', '=', $request->ReceiptNo)->exists()) {
         
            Alert::error('This Receipts has been posted'.strtoupper($request->ReceiptNo));
            return redirect()->back();
        }
        Deposits::create(  
            [  
            'MemberNo' => $request['MemberNo'],
            'Amount' => $request['Amount'],
            'TransBy' =>   'User',
            'sharescode' => $request['sharescode'],
            'ReceiptNo' => $request['ReceiptNo'],
            'mpesacode' => $request['ReceiptNo'],
            'Remarks' =>  ($request['Remarks']),
            'TransactionDate' =>  ($request['TransactionDate']),

        ]);
     
        Alert::success('Deposits Posting', 'Deposit Posting Successfull');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Deposits  $deposits
     * @return \Illuminate\Http\Response
     */
    public function show(Deposits $deposits)
    {
       
        $deposits = Deposits::all();
        return view('members.View_deposits',compact('deposits'));  
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Deposits  $deposits
     * @return \Illuminate\Http\Response
     */
    public function edit(Deposits $deposits)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Deposits  $deposits
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Deposits $deposits)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Deposits  $deposits
     * @return \Illuminate\Http\Response
     */
    public function destroy(Deposits $deposits)
    {
        //
    }
}
