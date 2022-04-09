<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
class SMS extends Model
{
    use HasFactory;
    protected $fillable=['phone','rType','status','message' ];
    public static function Sendsms()
    {
        $smspending =SMS::where('status', '=', '0')
      ->get();

    if ($smspending) {
      foreach ($smspending as $sms1) {
        $phoneNo = $sms1->phone;
        Log::info($smspending);
        $message = $sms1->message;
        $id = $sms1->id;       
        Log::info("This Works");
        Log::info($message);
  //exit();
          $curl = curl_init();
          $data = ['mobile' => $phoneNo, 'response_type' => 'json', 'sender_name' => '23107', 'service_id' => '0', 'message' => $message];
          curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.mobitechtechnologies.com/sms/sendsms',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 15,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode($data),
            CURLOPT_HTTPHEADER => array(
              'h_api_key: a26ab49ccea668ca3ab1b08cf5e04586cf48a7939612a32bac74024b0ef773e1',
              'Content-Type: application/json'
            ),
          ));

          $response = curl_exec($curl);
          Log::info($response);
      
          $jsonArray = json_decode($response);
          if($jsonArray ==null)
          {
            SMS::where('id', $id)
            ->update([
              'status' => 0,
              'remarks' => 'Not Sent,No internet Connection',
              'MessagID' => 0,

            ]);
            exit();
          }
          foreach ($jsonArray as $value) {
            $status_code = $value->status_code;
            $status_desc = $value->status_desc;
            $message_id = $value->message_id;
          }
          if ($status_code = 1000) {
            SMS::where('id', $id)
              ->update([
                'status' => 1,
                'remarks' => $status_desc,
                'MessagID' => $message_id,

              ]);
          } else {
            SMS::where('id', $id)
              ->update([
                'status' => 0,
                'remarks' => $status_desc,
                'MessagID' => $message_id,

              ]);
          }
          Log::info($response);
          curl_close($curl);
          echo $response;
      }
    }
      
   
    }
}
