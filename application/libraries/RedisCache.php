<?php defined('BASEPATH') OR exit('No direct script access allowed');

require 'vendor/autoload.php';

class RedisCache {

    private $Client;
    private $CI;

    function __construct() {

        $this->CI = &get_instance();

        $this->Client = new Predis\Client([
            'scheme' => 'tcp',
            'host'   => getenv('REDIS_HOST'),
            'port'   => getenv('REDIS_PORT'),
            'password' => getenv('REDIS_PASSWORD'),
        ]);

    }

    function set($Key, $Value, $Expiry = 300) {

        $ReturnData = new stdClass();

        $this->Client->set($Key, $Value);
        $this->Client->expiry($Key, $Expiry);

        $ReturnData->Message = "Successfully Set";
        $ReturnData->Status = true;

    }
    
    function get($Key) {
        $ReturnData = new stdClass();
        if($this->Client->exists($Key)) {
            $ReturnData->Message = "Successfully Retrieved";
            $ReturnData->Status = true;
            $ReturnData->Data = json_decode($this->Client->get($Key));
        } else {
            $ReturnData->Message = "Failed to Retrieve";
            $ReturnData->Status = false;
        }

        return $ReturnData;
    }
    
    function delete($Key) {

        $ReturnData = new stdClass();

        if($this->Client->exists($Key)) {

            $ReturnData->Message = "Successfully Deleted";
            $ReturnData->Status = true;
            $ReturnData->Data = $this->Client->del($Key);

        } else {
            $ReturnData->Message = "Failed to Delete";
            $ReturnData->Status = false;
        }

        return $ReturnData;

    }

}