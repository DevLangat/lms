<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\MpesaTransaction;
use App\Models\Deposits;
use App\Models\LoanApplication;
use App\Models\Repayments;
use App\Models\Member;
use Illuminate\Http\Request;
use App\Models\MpesaAPI;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;

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
    public function getB2C_access_token()
    {
        $access_token = MpesaAPI::generateB2CAccessToken();
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
        if (strpos($BillRefNumber, '-') !== false) {
            $memno = explode('-', $BillRefNumber);
            $MemberNo = $memno[0];
            $Remarks = $memno[1];
        } else {
            $MemberNo = $BillRefNumber;
            $Remarks = 'D';
        }
        Log::info($MemberNo);
        Log::info($Remarks);


        $userid = $MemberNo;
        //check deposit no
        $RecietNo = Deposits::getdepositsRecieptNo();
        if ($Remarks == 'R') {
            $loans = LoanApplication::select('Loanno')
                ->where('MemberNo', "=", $userid)
                ->get();
            Log::info($loans);
            foreach ($loans as $loanno) {
                Log::info($loanno);
                // foreach ($loanno->Loanno as $loannumber)
                // {
                $loannumber = $loanno->Loanno;
                Log::info($loannumber);
                $amount = DB::table('loan_applications')->where('Loanno', $loannumber)->pluck('ApprovedAmount')->sum();
                $payment = DB::table('repayments')->where('Loanno', $loannumber)->pluck('amount')->sum();
                $balance = $amount - $payment;
                Log::info($balance);
                // }


                if ($balance > 0) {
                    if ($balance = $TransAmount) {
                        $loanamount = $TransAmount;
                    } else if ($balance > $TransAmount) {
                        $loanamount = $TransAmount;
                    } else if ($balance < $TransAmount) {
                        $loanamount = $balance;
                        $Depositbal = $TransAmount - $balance;
                        Log::info($TransAmount);
                        Log::info($Depositbal);

                        if ($Depositbal > 0) {
                            Deposits::create(
                                [
                                    'MemberNo' => $MemberNo,
                                    'Amount' => $Depositbal,
                                    'TransBy' =>  $FirstName,
                                    'sharescode' => '001',
                                    'ReceiptNo' => $RecietNo,
                                    'mpesacode' => $TransID,
                                    'TransactionDate' => $TransTime,
                                    'Remarks' => $Remarks

                                ]
                            );
                            $DepAmount = DB::table('deposits')->where('MemberNo', $MemberNo)->pluck('Amount')->sum();
                            $loanlimit = $DepAmount * 3;
                            Log::info($loanlimit);
                            Member::where('MemberNo', $MemberNo)
                                ->update(['MaxLoan' => $loanlimit]);
                        }
                    }
                    $loanbal = $loanamount - $balance;
                    Log::info($balance);
                    Log::info($loanbal);
                    Log::info($loanamount);
                    repayments::create(
                        [
                            'Active' => 1,
                            'MemberNo' => $MemberNo,
                            'Loanno' => $loannumber,
                            'amount' => $loanamount,
                            'Principal' => $loanamount,
                            'Interest' => 0, //Balance
                            'Balance' =>  $loanbal,
                            'ReceiptNo' => $RecietNo,
                            'MobileNo' => $MSISDN,
                            'payment_status' => 1,
                            'TransactionDate' => $TransTime,
                            'AuditTime' => $TransTime
                        ]
                    );
                }
                // else if($balance<=0 && $TransAmount>0 )
                // {
                //     Deposits::create(
                //         [
                //             'MemberNo' => $MemberNo,
                //             'Amount' => $TransAmount,
                //             'TransBy' =>  $FirstName,
                //             'sharescode' => '001',
                //             'ReceiptNo' => $RecietNo,
                //             'mpesacode' => $TransID,
                //             'TransactionDate' => $TransTime,
                //             'Remarks' => $Remarks

                //         ]
                //     );
                // }



            }
        } else {
            Deposits::create(
                [
                    'MemberNo' => $MemberNo,
                    'Amount' => $TransAmount,
                    'TransBy' =>  $FirstName,
                    'sharescode' => '001',
                    'ReceiptNo' => $RecietNo,
                    'mpesacode' => $TransID,
                    'TransactionDate' => $TransTime,
                    'Remarks' => $Remarks

                ]
            );
            $DepAmount = DB::table('deposits')->where('MemberNo', $MemberNo)->pluck('Amount')->sum();
            $loanlimit = $DepAmount * 3;
            Log::info($loanlimit);
            Member::where('MemberNo', $MemberNo)
                ->update(['MaxLoan' => $loanlimit]);
        }
        MpesaTransaction::create([
            'FirstName' => $FirstName,
            'MiddleName' => '',
            'LastName' => '',
            'TransactionType' => $TransactionType,
            'TransID' => $TransID,
            'TransTime' => $TransTime,
            'BusinessShortCode' => $BusinessShortCode,
            'BillRefNumber' => $BillRefNumber,
            'InvoiceNumber' => $InvoiceNumber,
            'ThirdPartyTransID' => "",
            'MSISDN' => $MSISDN,
            'TransAmount' => $TransAmount,
            'OrgAccountBalance' => $OrgAccountBalance
        ]);


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
    public function lipaNaMpesaPassword()
    {
        $lipa_time = Carbon::rawParse('now')->format('YmdHms');
        $passkey = env('MPESA_PASS_KEY');
        $BusinessShortCode = 4088191;
        $timestamp = $lipa_time;
        $lipa_na_mpesa_password = base64_encode($BusinessShortCode . $passkey . $timestamp);
        return $lipa_na_mpesa_password;
    }
    public function customerMpesaSTKPush(Request $request)
    {
        Log::info($request->all());
        $access_token = MpesaAPI::generateC2BAccessToken();
        $url = 'https://api.safaricom.co.ke/mpesa/stkpush/v1/processrequest';
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        Log::info($access_token);

        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json', 'Authorization:Bearer ' . $access_token));
        $curl_post_data = [
            //Fill in the request parameters with valid values
            'BusinessShortCode' => env('MPESA_SHORTCODE'),
            'Password' => $this->lipaNaMpesaPassword(),
            'Timestamp' => Carbon::rawParse('now')->format('YmdHms'),
            'TransactionType' => 'CustomerPayBillOnline',
            'Amount' => $request->amount,
            'PartyA' => $request->phone, // replace this with your phone number
            'PartyB' => env('MPESA_SHORTCODE'),
            'PhoneNumber' =>  $request->phone, // replace this with your phone number
            'CallBackURL' => 'http://floridaylimited.co.ke/',
            'AccountReference' => $request->Account,
            'TransactionDesc' => "Pay Loan"
        ];
        $data_string = json_encode($curl_post_data);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
        $curl_response = curl_exec($curl);
        return $curl_response;
    }
    public static function  send_loan(Request $request)
    {
        Log::info($request->phone);
        Log::info($request->amount);
        exit();
        // /** Get approved loan appliactions that have not beemn disbursed yet
        //  * This could be fetched through a background job
        //  */
        // $loan_status_id = LoanStatus::APPROVED;
        // $active_loans = Loan::where('loan_status_id', $loan_status_id)->first();

        // /** Get user phone number based on the user_id */

        // $PhoneNumber = User::where('id', $active_loans->user_id)->first();
        // $Amount = $active_loans->disbursed;
        $B2CEnvironment = env('B2C_ENV');
       

        $token = MpesaAPI::generateB2CAccessToken(); 

        $Credential = $this->SecurityCredentials();
        Log::info("Token");
        Log::info($token);

        Log::info($Credential);
        if ($B2CEnvironment == 'live') {

            if ($B2CEnvironment)

                $url = 'https://api.safaricom.co.ke/mpesa/b2c/v1/paymentrequest';
        } elseif ($B2CEnvironment == 'sandbox') {

            $url = 'https://sandbox.safaricom.co.ke/mpesa/b2c/v1/paymentrequest';
        } else {
            return json_encode(['Message' => 'invalid application status']);
        }


        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json', 'Authorization:Bearer ' . $token));
      

        $InitiatorName =env('B2C_INITIATOR_NAME');
        $SecurityCredential = $Credential;
        $CommandID = "SalaryPayment";
        $Amount = 5;
        $PartyA = env('B2C_SHORTCODE');       
        $PartyB = 254791088999;
        $Remarks = "Loan disbursement";
        $QueueTimeOutURL = "https://lms.floridaylimited.co.ke/api/queue_timeout_url";
        $ResultURL = "https://lms.floridaylimited.co.ke/api/result_url";
        $Occasion = "Loan Disbursement";

        /** MPESA B2C post data */
        $curl_post_data = array(
            'InitiatorName' => $InitiatorName,
            'SecurityCredential' => $SecurityCredential,
            'CommandID' => $CommandID,
            'Amount' => $Amount,
            'PartyA' => $PartyA,
            'PartyB' => $PartyB,
            'Remarks' => $Remarks,
            'QueueTimeOutURL' => $QueueTimeOutURL,
            'ResultURL' => $ResultURL,
            'Occasion' => $Occasion
        );

        Log::info("B2C Data");
        Log::info($curl_post_data);

        $data_string = json_encode($curl_post_data);
        $data_string1 = json_decode($data_string, true);

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);

        $curl_response = curl_exec($curl);
        $array = (array) $curl_response;
        $array1 = $array[0];

        $res1 = json_decode($array1, true);
        $res2 = json_decode(json_encode($res1), true);
        Log::info($res2);
        Log::info($res1);

        // try {

        //     $resCode = $res2['ResponseCode'];

        //     /** Update the loan status id to 4 - Sent */
        //     $new_loan_status_id = 4;
        //     $new_loan_status_array = array(
        //         'loan_status_id' => $new_loan_status_id
        //     );

        //     $update_loan_status = Loan::where('id', $active_loans->id)->update($new_loan_status_array);

        //     /** Log the successful transaction */
        //     $current_date_and_time = Carbon::now('Africa/Nairobi');
        //     Log::info("-----------------Start New Transaction Entry (Loan Disbursement)-----------------");
        //     Log::info("Phone Number: " . $PhoneNumber . "Amount: " . $Amount . "Date and Time: " . $current_date_and_time);
        //     Log::info("-----------------Stop New Transaction Entry (Loan Disbursement)-----------------");
        // } catch (\Throwable $e) {
        //     $msg = $res2['errorMessage'];

        //     \Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
        // }
    }
    public function queue_timeout_url()
    {

        header("Content-Type:application/json");

        // Receive Json string from Safaricom

        $request = file_get_contents('php://input');

        //Put the json string that we received from Safaricom to an array


        //$array = json_decode($request, true);

        file_put_contents("B2CFailMpesa.json", $request);
    }
    public function result_url()
    {
        // try {
        header("Content-Type:application/json");

        $B2CResponse = file_get_contents('php://input');

        $decResponse = json_decode($B2CResponse, true);

        //$ResultCode = $B2CResponse['Result']);
        //file_put_contents("B2CResultResponseTest.txt", $ResultCode);

        $result = json_encode($decResponse['Result']['ResultParameters']['ResultParameter']);

        $dec1Response = json_decode($result, true);

        $TransactionReceipt = str_replace('"', '', json_encode($dec1Response[1]['Value']));
        $TransactionAmount = str_replace('"', '', json_encode($dec1Response[0]['Value']));
        $B2CWorkingAccountAvailableFunds = str_replace('"', '', json_encode($dec1Response[5]['Value']));
        $B2CUtilityAccountAvailableFunds = str_replace('"', '', json_encode($dec1Response[4]['Value']));
        $TransactionCompletedDateTime = str_replace('"', '', json_encode($dec1Response[3]['Value']));
        $ReceiverPartyPublicName = str_replace('"', '', json_encode($dec1Response[2]['Value']));
        $ReceiverPartyPublicName = explode(' - ', trim($ReceiverPartyPublicName));
        $ReceiverPartyPhone = $ReceiverPartyPublicName[0];
        $ReceiverPartyName = !empty($ReceiverPartyPublicName[1]) ? $ReceiverPartyPublicName[1] : "No Name";
        $B2CChargesPaidAccountAvailableFunds = str_replace('"', '', json_encode($dec1Response[7]['Value']));
        $B2CRecipientIsRegisteredCustomer = str_replace('"', '', json_encode($dec1Response[6]['Value']));

        // $TransactionReceipt = str_replace('"', '', json_encode($dec1Response[0]['Value']));
        // $TransactionAmount = str_replace('"', '', json_encode($dec1Response[1]['Value']));
        // $B2CWorkingAccountAvailableFunds = str_replace('"', '', json_encode($dec1Response[2]['Value']));
        // $B2CUtilityAccountAvailableFunds = str_replace('"', '', json_encode($dec1Response[3]['Value']));
        // $TransactionCompletedDateTime = str_replace('"', '', json_encode($dec1Response[4]['Value']));
        // $ReceiverPartyPublicName = str_replace('"', '', json_encode($dec1Response[5]['Value']));
        // $ReceiverPartyPublicName = explode(' - ', trim($ReceiverPartyPublicName));
        // $ReceiverPartyPhone = $ReceiverPartyPublicName[0];
        // $ReceiverPartyName = !empty($ReceiverPartyPublicName[1]) ? $ReceiverPartyPublicName[1] : "No Name";
        // $B2CChargesPaidAccountAvailableFunds = str_replace('"', '', json_encode($dec1Response[6]['Value']));
        // $B2CRecipientIsRegisteredCustomer = str_replace('"', '', json_encode($dec1Response[7]['Value']));

        // $pay_exists = Payment::where('TransactionReceipt', $TransactionReceipt)->first();

        // if (empty($pay_exists)) {
        //     $payment = new Payment();
        //     $payment->TransactionReceipt = $TransactionReceipt;
        //     $payment->TransactionAmount = $TransactionAmount;
        //     $payment->B2CWorkingAccountAvailableFunds = $B2CWorkingAccountAvailableFunds;
        //     $payment->B2CUtilityAccountAvailableFunds = $B2CUtilityAccountAvailableFunds;
        //     $payment->TransactionCompletedDateTime = $TransactionCompletedDateTime;
        //     $payment->ReceiverPartyPhone = $ReceiverPartyPhone;
        //     $payment->ReceiverPartyName = $ReceiverPartyName;
        //     $payment->B2CChargesPaidAccountAvailableFunds = $B2CChargesPaidAccountAvailableFunds;
        //     $payment->B2CRecipientIsRegisteredCustomer = $B2CRecipientIsRegisteredCustomer;

        //     $payment->save();


        //     file_put_contents("B2CResultResponse.txt", $payment);
        //     file_put_contents("B2CResultResponse.json", $payment);
        // }


        // file_put_contents("B2CResultResponse.json", $decResponse);
        // } catch (\Throwable $e) {

        //     DB::rollBack();
        //     \Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
        // }


        //$array = json_decode($request, true);
    }
    public function validation()
    {
        header('Content-Type: application/json');

        $response = '{
            "ResultCode": 0,
            "ResultDesc": "Validation Received Successfully"
        }';
    }

    public function SecurityCredentials ()
    {
       
        // if (env('B2C_ENV')=='sandbox') {
        //     $pubkey=File::get(__DIR__.'/cert/sandbox.cer');
        // } else {
        //     $pubkey=File::get(__DIR__.'/cert/production.cer');
        // }
        $certificate='-----BEGIN CERTIFICATE-----
MIIGkzCCBXugAwIBAgIKXfBp5gAAAD+hNjANBgkqhkiG9w0BAQsFADBbMRMwEQYK
CZImiZPyLGQBGRYDbmV0MRkwFwYKCZImiZPyLGQBGRYJc2FmYXJpY29tMSkwJwYD
VQQDEyBTYWZhcmljb20gSW50ZXJuYWwgSXNzdWluZyBDQSAwMjAeFw0xNzA0MjUx
NjA3MjRaFw0xODAzMjExMzIwMTNaMIGNMQswCQYDVQQGEwJLRTEQMA4GA1UECBMH
TmFpcm9iaTEQMA4GA1UEBxMHTmFpcm9iaTEaMBgGA1UEChMRU2FmYXJpY29tIExp
bWl0ZWQxEzARBgNVBAsTClRlY2hub2xvZ3kxKTAnBgNVBAMTIGFwaWdlZS5hcGlj
YWxsZXIuc2FmYXJpY29tLmNvLmtlMIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIB
CgKCAQEAoknIb5Tm1hxOVdFsOejAs6veAai32Zv442BLuOGkFKUeCUM2s0K8XEsU
t6BP25rQGNlTCTEqfdtRrym6bt5k0fTDscf0yMCoYzaxTh1mejg8rPO6bD8MJB0c
FWRUeLEyWjMeEPsYVSJFv7T58IdAn7/RhkrpBl1dT7SmIZfNVkIlD35+Cxgab+u7
+c7dHh6mWguEEoE3NbV7Xjl60zbD/Buvmu6i9EYz+27jNVPI6pRXHvp+ajIzTSsi
eD8Ztz1eoC9mphErasAGpMbR1sba9bM6hjw4tyTWnJDz7RdQQmnsW1NfFdYdK0qD
RKUX7SG6rQkBqVhndFve4SDFRq6wvQIDAQABo4IDJDCCAyAwHQYDVR0OBBYEFG2w
ycrgEBPFzPUZVjh8KoJ3EpuyMB8GA1UdIwQYMBaAFOsy1E9+YJo6mCBjug1evuh5
TtUkMIIBOwYDVR0fBIIBMjCCAS4wggEqoIIBJqCCASKGgdZsZGFwOi8vL0NOPVNh
ZmFyaWNvbSUyMEludGVybmFsJTIwSXNzdWluZyUyMENBJTIwMDIsQ049U1ZEVDNJ
U1NDQTAxLENOPUNEUCxDTj1QdWJsaWMlMjBLZXklMjBTZXJ2aWNlcyxDTj1TZXJ2
aWNlcyxDTj1Db25maWd1cmF0aW9uLERDPXNhZmFyaWNvbSxEQz1uZXQ/Y2VydGlm
aWNhdGVSZXZvY2F0aW9uTGlzdD9iYXNlP29iamVjdENsYXNzPWNSTERpc3RyaWJ1
dGlvblBvaW50hkdodHRwOi8vY3JsLnNhZmFyaWNvbS5jby5rZS9TYWZhcmljb20l
MjBJbnRlcm5hbCUyMElzc3VpbmclMjBDQSUyMDAyLmNybDCCAQkGCCsGAQUFBwEB
BIH8MIH5MIHJBggrBgEFBQcwAoaBvGxkYXA6Ly8vQ049U2FmYXJpY29tJTIwSW50
ZXJuYWwlMjBJc3N1aW5nJTIwQ0ElMjAwMixDTj1BSUEsQ049UHVibGljJTIwS2V5
JTIwU2VydmljZXMsQ049U2VydmljZXMsQ049Q29uZmlndXJhdGlvbixEQz1zYWZh
cmljb20sREM9bmV0P2NBQ2VydGlmaWNhdGU/YmFzZT9vYmplY3RDbGFzcz1jZXJ0
aWZpY2F0aW9uQXV0aG9yaXR5MCsGCCsGAQUFBzABhh9odHRwOi8vY3JsLnNhZmFy
aWNvbS5jby5rZS9vY3NwMAsGA1UdDwQEAwIFoDA9BgkrBgEEAYI3FQcEMDAuBiYr
BgEEAYI3FQiHz4xWhMLEA4XphTaE3tENhqCICGeGwcdsg7m5awIBZAIBDDAdBgNV
HSUEFjAUBggrBgEFBQcDAgYIKwYBBQUHAwEwJwYJKwYBBAGCNxUKBBowGDAKBggr
BgEFBQcDAjAKBggrBgEFBQcDATANBgkqhkiG9w0BAQsFAAOCAQEAC/hWx7KTwSYr
x2SOyyHNLTRmCnCJmqxA/Q+IzpW1mGtw4Sb/8jdsoWrDiYLxoKGkgkvmQmB2J3zU
ngzJIM2EeU921vbjLqX9sLWStZbNC2Udk5HEecdpe1AN/ltIoE09ntglUNINyCmf
zChs2maF0Rd/y5hGnMM9bX9ub0sqrkzL3ihfmv4vkXNxYR8k246ZZ8tjQEVsKehE
dqAmj8WYkYdWIHQlkKFP9ba0RJv7aBKb8/KP+qZ5hJip0I5Ey6JJ3wlEWRWUYUKh
gYoPHrJ92ToadnFCCpOlLKWc0xVxANofy6fqreOVboPO0qTAYpoXakmgeRNLUiar
0ah6M/q/KA==
-----END CERTIFICATE-----';
        $encrypted='';        
        
        $initiatorPass ='Vanlin123$%';

        openssl_public_encrypt($initiatorPass, $encrypted, openssl_pkey_get_public($certificate), OPENSSL_PKCS1_PADDING);

        $SecurityCred=base64_encode($encrypted);
        return $SecurityCred;
    }

   
}
