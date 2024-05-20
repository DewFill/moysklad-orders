<?php

namespace controllers;

use models\User;

class FetchController
{
    public static function fetch($url)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                "Authorization: Bearer " . User::getToken()
            ),
        ));

        $response = curl_exec($curl);
        $response = json_decode($response, true);
        if(isset($response["errors"])) {
            (new AuthController())->viewAuth();
            die();
        }

        curl_close($curl);

        return $response;
    }
}