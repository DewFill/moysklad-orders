<?php

namespace models;

use Exception;
use SensitiveParameter;

class User
{
    /**
     * @throws Exception
     */
    static function generateTokenOrThrow(string $login, #[SensitiveParameter] string $password)
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://api.moysklad.ru/api/remap/1.2/security/token');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);

        $headers = array();
        $credentials = base64_encode("$login:$password");
        $headers[] = "Authorization: Basic $credentials";
        $headers[] = 'Accept-Encoding: gzip';
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }
        curl_close($ch);

        $result = json_decode($result, true);
        return $result["access_token"] ?? throw new Exception($result["errors"][0]["error"] ?? "Unknown error");
    }

    static function getToken()
    {
       if (isset($_COOKIE["token"])) return $_COOKIE["token"];
       return false;
    }
}