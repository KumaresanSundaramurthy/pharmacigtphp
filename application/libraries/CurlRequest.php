<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CurlRequest {

    private $ReturnData;
    private $CI;

    function __construct() {

        $this->CI = &get_instance();
        
    }

    function ServiceRequest($Url, $Method = 'GET', $HttpHeader = [], $PostData = []) {

        $this->ReturnData = new stdClass();

        try {

            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, $Url);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $Method);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $HttpHeader);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $PostData);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            $response = curl_exec($ch);
            $HttpRespCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

            $CurlError = curl_errno($ch);
            if ($CurlError > 0) {
                $errorMessage = 'cURL Error: ' . curl_error($ch);
                curl_close($ch);
                throw new Exception($errorMessage);
            }

            curl_close($ch);

            $JsonResponse = json_decode($response);

            if ($HttpRespCode >= 200 && $HttpRespCode < 300) {

                $this->ReturnData->Message = 'Success Retrieved';
                $this->ReturnData->Status = true;
                $this->ReturnData->Data = $JsonResponse;

            } else {
                $this->ReturnData->Message = $JsonResponse->Message;
                $this->ReturnData->Status = false;
            }

        } catch (Exception $e) {
            $this->ReturnData->Message = $e->getMessage();
            $this->ReturnData->Status = false;
        }

        return $this->ReturnData;

    }

}