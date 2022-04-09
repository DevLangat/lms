<?php

namespace App\Http\Controllers;

use App\Models\LoanInterest;
use Illuminate\Http\Request;

class LoanInterestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\LoanInterest  $loanInterest
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $showinterests = LoanInterest::select(
            "loan_interests.*",             
            "members.name as Names"
        )
        ->join("members", "members.MemberNo", "=", "loan_interests.MemberNo")
        // ->where ('LoanInterest.Approved',"=",'2')
        ->get();
        return view('members.view_interests', compact('showinterests'));
        //['Loanno','MemberNo','ApprovedAmount','InterestAmount','ApprovedBy']
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\LoanInterest  $loanInterest
     * @return \Illuminate\Http\Response
     */
    public function edit(LoanInterest $loanInterest)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\LoanInterest  $loanInterest
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, LoanInterest $loanInterest)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\LoanInterest  $loanInterest
     * @return \Illuminate\Http\Response
     */
    public function destroy(LoanInterest $loanInterest)
    {
        //
    }
}
