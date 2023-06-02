<?php

declare(strict_types=1);

namespace App\Utils;

final class GeneralUtil implements GeneralUtilInterface
{
    public static function CURLCallCARAPI($endPoint, $request, $data, $method = 'GET')
    {
        $sessionData = $request->getSession();
        $sessionData->get('carApiToken');
        $url = $_ENV['CAR_API_URL'] . $endPoint;
        $curl = curl_init();

        // Build url as query string if get method
        if($method == 'GET') {
            $url = $url .'?'. http_build_query($data);
        }

        $curlOptions = [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_HTTPHEADER => [
                'Authorization: Bearer ' . $sessionData->get('carApiToken'),
                'Content-Type: application/json',
                'Cache-Control: no-cache',
            ]
        ];

        // It will be used when method post
        if(!empty($data) && $method == 'POST') {
            $curlOptions[CURLOPT_POSTFIELDS] = json_encode($data);
        }

        curl_setopt_array($curl, $curlOptions);
        $response = curl_exec($curl);
        curl_close($curl);
        return json_decode($response);
    }


    public static function CurlCallLoginApi($endPoint, $request, $data, $method = 'GET')
    {
        $data = array('api_token' => '9ecb27a8-c1dd-4630-9f70-6d1c0ade1235', 'api_secret' => '13592e0f2f841f45f7c0531fbbed1ff1');
        $url = $_ENV['CAR_API_URL'].$endPoint;
        $curl = curl_init();

        // Build url as query string if get method
        if($method == 'GET') {
            $url = $url .'?'. http_build_query($data);
        }

        $curlOptions = [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_HTTPHEADER => [
                // 'api_token: ' . $_ENV['CAR_APT_TOKEN'],
                // 'api_secret: ' . $_ENV['CAR_API_SECRET'],
                'Content-Type: application/json',
                'Cache-Control: no-cache',
            ]
        ];

        // It will be used when method post
        if(!empty($data) && $method == 'POST') {
            $curlOptions[CURLOPT_POSTFIELDS] = json_encode($data);
        }

        curl_setopt_array($curl, $curlOptions);
        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }
}
