<?php

namespace App\Http\Controllers;

use App\Models\LoanApplication;
use App\Models\LoanType;
use App\Models\Member;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Log;
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
        return view('members.loanapplication',compact('loantypes'));
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
        LoanApplication::create($request->all());
        Alert::error('Loan Application', 'You\'ve Successfully Applied');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\LoanApplication  $loanApplication
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $showloans = LoanApplication::all();
        return view('members.View_LoanApplications',compact('showloans')); 

        $showloans = LoanApplication::join('loan_applications', 'loan_applications.IDNo', '=', 'Members.IdNumber')
        ->where('SalesDate', '>=', $now)
        ->where('SalesDate', '<=', $to)
        ->get(['sales.*', 'products.Productname']);

    }
 
    public function getUserbyid(Request $request){
 
        $userid = $request->userid;
   
        
        $members = Member::select('*')->where('IdNumber', $userid)->get();
        if($members){
             // Fetch all records
        foreach ($members as $member)
        Log::info($member->Name);
        return response()->json([
            'member'=> $member
        ]);
        }
        else{
            Alert::error('No Member','The Member with ID No.'.strtoupper($request->userid).' '.' is not found');
            
        }
       
     }
    public function getLoantypes(Request $request){
 
        $loancode = $request->loancode;
   
        $loantypes = LoanType::select('*')->where('LoanCode', $loancode)->get();
        if($loantypes){
             // Fetch all records
        foreach ($loantypes as $loantype)
        Log::info($loantype->Ratio);
        return response()->json([
            'loantype'=> $loantype
        ]);
        }
        else{
            Alert::error('No Member','The Member with ID No.'.strtoupper($request->userid).' '.' is not found');
            
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
         
            $member=Member::all();
            return $member;
            Log::info('Wjahtttts');
        }
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\LoanApplication  $loanApplication
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, LoanApplication $loanApplication)
    {
        //
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
