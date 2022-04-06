<?php

namespace App\Http\Controllers;

use App\Models\MpesaTransaction;
use App\Models\Deposits;
use App\Models\Member;
use Illuminate\Http\Request;
use App\Models\MpesaAPI;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
class MpesaTransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function get_access_token()
    {
        $access_token = MpesaAPI::generateC2BAccessToken();
        echo $access_token;
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function confirmation_url()
    {

        header('Content-Type: application/json');

        $response = '{
            "ResultCode": 0,
            "ResultDesc": "Confirmation Received Successfully"
        }';

        // Response from M-PESA Stream
        $mpesaResponse = file_get_contents('php://input');

        $current_time = Carbon::now('Africa/Nairobi');
        $PayDate = $current_time->toDateString();
        $PayTime = $current_time->toTimeString();

        // log the daily response in a .json file
        $logFile = $PayDate . 'MPESAConfirmationResponse.json';

        $jsonMpesaResponse = json_decode($mpesaResponse, true);

        /** Log the transaction details in the daily log file */
        Log::info("-----------------START MPESA LOGGING PROCESS------------------------------");
        Log::info(print_r($mpesaResponse, true));
        Log::info(print_r($jsonMpesaResponse, true));
        Log::info("-----------------STOP MPESA LOGGING PROCESS------------------------------");

        // /** Capture the Mpesa response parameters */
        // $TransID = $jsonMpesaResponse['TransID'];
        // $TransAmount = $jsonMpesaResponse['TransAmount'];
        // $BillRefNumber = SMS::validate_phone_number($jsonMpesaResponse['BillRefNumber']);
        // $OrgAccountBalance = $jsonMpesaResponse['OrgAccountBalance'];
        // $MSISDN = $jsonMpesaResponse['MSISDN'];

        
        $TransactionType = $jsonMpesaResponse['TransactionType'];
        $TransID = $jsonMpesaResponse['TransID'];
        $TransAmount = $jsonMpesaResponse['TransAmount'];
        $BusinessShortCode = $jsonMpesaResponse['BusinessShortCode'];
        $BillRefNumber = ucwords($jsonMpesaResponse['BillRefNumber']);
        $InvoiceNumber = $jsonMpesaResponse['InvoiceNumber'];
        $OrgAccountBalance = $jsonMpesaResponse['OrgAccountBalance'];
        $MSISDN = $jsonMpesaResponse['MSISDN'];
        $FirstName = $jsonMpesaResponse['FirstName'];
        // $MiddleName = $jsonMpesaResponse['MiddleName'];
        // $LastName = $jsonMpesaResponse['LastName'];
        $TransTime = $jsonMpesaResponse['TransTime'];
        $memno = explode('-', $BillRefNumber);
        $MemberNo=$memno[0];
        $Remarks=$memno[1];
        Log::info($MemberNo);

        //check deposit no
        $RecietNo=Deposits::getdepositsRecieptNo();
       
        Deposits::create(  
            [  
            'MemberNo' => $MemberNo,
            'Amount' => $TransAmount,            
            'TransBy' =>  $FirstName,
            'sharescode' => '',
            'ReceiptNo' => $RecietNo,
            'mpesacode' => $TransID,
            'TransactionDate' => $TransTime,
            'Remarks'=>$Remarks

        ]);
       MpesaTransaction::create([
        'FirstName'=>$FirstName,
        'MiddleName'=>'',
        'LastName'=>'',
        'TransactionType'=>$TransactionType,
        'TransID'=>$TransID,
        'TransTime'=>$TransTime,
        'BusinessShortCode'=>$BusinessShortCode,
        'BillRefNumber'=>$BillRefNumber,
        'InvoiceNumber'=>$InvoiceNumber,
        'ThirdPartyTransID'=>"",
        'MSISDN'=>$MSISDN,
        'TransAmount'=>$TransAmount,
        'OrgAccountBalance'=>$OrgAccountBalance]);

    
        //get totalDeposits
        //get loanBalance
            //create sms
            //call automessaging

        // write to file
        $log = fopen($logFile, 'a');
        fwrite($log, $mpesaResponse);
        fclose($log);

        echo $response;
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
     * @param  \App\Models\MpesaTransaction  $mpesaTransaction
     * @return \Illuminate\Http\Response
     */
    public function validation()
    {
        header('Content-Type: application/json');

        $response = '{
            "ResultCode": 0,
            "ResultDesc": "Validation Received Successfully"
        }';

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MpesaTransaction  $mpesaTransaction
     * @return \Illuminate\Http\Response
     */
    public function edit(MpesaTransaction $mpesaTransaction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\MpesaTransaction  $mpesaTransaction
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MpesaTransaction $mpesaTransaction)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MpesaTransaction  $mpesaTransaction
     * @return \Illuminate\Http\Response
     */
    public function destroy(MpesaTransaction $mpesaTransaction)
    {
        //
    }
}
