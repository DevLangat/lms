<?php

namespace App\Http\Controllers;

use App\Models\CompanyParameters;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class CompanyParametersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.company_parameters');
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
        CompanyParameters::create($request->all());
        Alert::success('Company', 'You\'ve Successfully Registered');

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CompanyParameters  $companyParameters
     * @return \Illuminate\Http\Response
     */
    public function show(CompanyParameters $companyParameters)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CompanyParameters  $companyParameters
     * @return \Illuminate\Http\Response
     */
    public function edit(CompanyParameters $companyParameters)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CompanyParameters  $companyParameters
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CompanyParameters $companyParameters)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CompanyParameters  $companyParameters
     * @return \Illuminate\Http\Response
     */
    public function destroy(CompanyParameters $companyParameters)
    {
        //
    }
}
