<?php

namespace App\Models;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MpesaAPI extends Model
{
    use HasFactory;

    /** Generate C2B Access token */
    public static function generateC2BAccessToken()
    {

        try {
            $consumer_key = env('MPESA_CONSUMER_KEY');
            $consumer_secret = env('MPESA_CONSUMER_SECRET');
        } catch (\Throwable $th) {
            $consumer_key = self::env('MPESA_CONSUMER_KEY');
            $consumer_secret = self::env('MPESA_CONSUMER_SECRET');
        }

        if (!isset($consumer_key) || !isset($consumer_secret)) {
            die('please declare the consumer key and consumer secret as defined in the documentation');
        }

        /** Get C2B Access Token 
         * Check env variable (MPESA_ENV) & use the required URL
        */

        $environment = env('MPESA_ENV');
        if ($environment == 'live') {
            $url = 'https://api.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials';
        } elseif ($environment == 'sandbox') {
            $url = 'https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials';
        }

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        $credentials = base64_encode($consumer_key . ':' . $consumer_secret);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Authorization: Basic ' . $credentials));
        //setting a custom header
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

        $curl_response = curl_exec($curl);

        return json_decode($curl_response)->access_token;
    }


/** Get B2C Access token */
    public static function generateB2CAccessToken()
    {

        try {
            $consumer_key = env('MPESA_CONSUMER_KEY');
            $consumer_secret = env('MPESA_CONSUMER_SECRET');
        } catch (\Throwable $th) {
            $consumer_key = self::env('MPESA_CONSUMER_KEY');
            $consumer_secret = self::env('MPESA_CONSUMER_SECRET');
        }

        if (!isset($consumer_key) || !isset($consumer_secret)) {
            die('please declare the consumer key and consumer secret as defined in the documentation');
        }

        /** Get Access Token */

        $environment = env('MPESA_ENV');
        if ($environment == 'live') {
            $url = 'https://api.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials';
        } elseif ($environment == 'sandbox') {
            $url = 'https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials';
        }

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        $credentials = base64_encode($consumer_key . ':' . $consumer_secret);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Authorization: Basic ' . $credentials));
        //setting a custom header
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

        $curl_response = curl_exec($curl);
    

        return json_decode($curl_response)->access_token;
        
    }
}

