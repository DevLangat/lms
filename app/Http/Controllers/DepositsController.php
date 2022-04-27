<?php

namespace App\Http\Controllers;

use App\Models\Deposits;
use App\Models\DepositTypes;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert; 
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Carbon;
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
    public function getdeposittypes(Request $request)
    {

        $sharescode = $request->sharecode;

        $sharetypes = DepositTypes::select('*')->where('sharescode', $sharescode)->get();
        if ($sharetypes) {
            // Fetch all records
            foreach ($sharetypes as $sharetype)
                Log::info($sharetype->Ratio);
            return response()->json([
                'Sharesname' => $sharetype
            ]);
        } else {
            Alert::error('No Member', 'The Member with ID No.' . strtoupper($request->userid) . ' ' . ' is not found');
        }
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
            'TransBy' =>   [auth()->user()],
            // 'TransBy' =>   'User',
            'sharescode' => $request['sharescode'],
            'ReceiptNo' => $request['ReceiptNo'],
            'mpesacode' => $request['ReceiptNo'],
            'TransactionDate' =>  ($request['TransactionDate']),
            'Remarks'=>$request->Remarks

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
        $deposits = Deposits::select(
            "deposits.*",             
            "members.name as Names"
        )
        ->join("members", "members.MemberNo", "=", "deposits.MemberNo")
        ->get();
        return view('members.View_deposits',compact('deposits'));  
         


       
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Deposits  $deposits
     * @return \Illuminate\Http\Response
     */
   

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
