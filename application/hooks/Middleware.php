<?php defined('BASEPATH') OR exit('No direct script access allowed');

require 'vendor/autoload.php';

use \Firebase\JWT\JWT;
use \Firebase\JWT\Key;

class Middleware {

    private $ExcludeController = [];
    private $CI;

    function validateUserJwt() {

        $this->CI = &get_instance();

        $Controller = $this->CI->router->fetch_class();
        $Method = $this->CI->router->fetch_method();

        if(in_array($Controller, $this->ExcludeController)) {

        } else {

            if($Controller == 'main' && ($Method == "index" || $Method == "login" || $Method == "login_validation")) {

            } else {

                $GetCookieData = get_cookie(getenv('JWT_COOKIE_NAME'));
                if(!empty($GetCookieData)) {

                    $JwtDecoded = JWT::decode($GetCookieData, new key(getenv('JWT_SECRET'), 'HS256'));
                    if(!empty($JwtDecoded) && isset($JwtDecoded->data)) {

                        $this->CI->load->library('rediscache');
                        $RedisData = $this->CI->rediscache->get($JwtDecoded->data);
                        if($RedisData->Status) {

                            $this->CI->userData = json_decode(json_encode($RedisData->Data), true);

                        } else {
                            $this->session->set_flashdata('error', 'Session is expired. Please login again.!');
				            redirect(base_url() . 'main/login');
                        }

                    } else {
                        $this->session->set_flashdata('error', 'Session is expired. Please login again.!');
				        redirect(base_url() . 'main/login');
                    }

                } else {
                    $this->session->set_flashdata('error', 'Session is expired. Please login again.!');
				    redirect(base_url() . 'main/login');
                }

            }
            
        }

    }

}