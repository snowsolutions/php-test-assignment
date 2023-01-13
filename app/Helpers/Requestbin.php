<?php

namespace App\Helpers;

class Requestbin
{

    const WORKFLOW_API_URL = "https://eok5esiw2xnmvwk.m.pipedream.net";

    public static function ping($data)
    {
        $handle = curl_init(self::WORKFLOW_API_URL);
        $encodedData = json_encode($data);
        curl_setopt($handle, CURLOPT_POST, 1);
        curl_setopt($handle, CURLOPT_POSTFIELDS, $encodedData);
        curl_setopt($handle, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_exec($handle);
    }
}
