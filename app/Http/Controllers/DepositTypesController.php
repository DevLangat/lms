<?php

namespace App\Http\Controllers;

use App\Models\DepositTypes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
class DepositTypesController extends Controller
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
     * @param  \App\Models\DepositTypes  $depositTypes
     * @return \Illuminate\Http\Response
     */
    public function show(DepositTypes $depositTypes)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\DepositTypes  $depositTypes
     * @return \Illuminate\Http\Response
     */
    public function edit(DepositTypes $depositTypes)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\DepositTypes  $depositTypes
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DepositTypes $depositTypes)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\DepositTypes  $depositTypes
     * @return \Illuminate\Http\Response
     */
    public function destroy(DepositTypes $depositTypes)
    {
        //
    }
}
