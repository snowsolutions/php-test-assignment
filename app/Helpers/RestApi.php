<?php

namespace App\Helpers;

class RestApi
{
    public function call($url, $method, $header, $data = [], $options = [])
    {
        try {
            $curlResource = curl_init();

            $baseOptions = [
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_URL => $url,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => $method,
                CURLOPT_HTTPHEADER => $header
            ];


            $curlOptions = $baseOptions + $options;

            if (!empty($data)) {
                if (in_array($method, ['POST', 'PUT', 'PATCH', 'UPDATE', 'OPTIONS'])) {
                    $data = json_encode($data);
                    $curlOptions[CURLOPT_POSTFIELDS] = $data;
                }
                if ($method === 'GET') {
                    $paramQuery = '';
                    $countParam = 0;
                    foreach ($data as $paramKey => $paramValue) {
                        $countParam++;
                        if ($countParam === 1) {
                            $paramQuery .= "?$paramKey=$paramValue";
                        } else {
                            $paramQuery .= "&$paramKey=$paramValue";
                        }
                    }
                    $urlWithQueryParams = $url . $paramQuery;
                    $curlOptions[CURLOPT_URL] = $urlWithQueryParams;
                }

            }

            curl_setopt_array($curlResource, $curlOptions);

            $response = curl_exec($curlResource);

            curl_close($curlResource);

            return $response;
        } catch (\Exception $exception) {
            dd($exception->getMessage());
        }
    }
}
