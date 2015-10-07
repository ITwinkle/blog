<?php

namespace Framework\Security;

use Framework\DI\Service;

class NoCrsf
{
    public static function generate(){
        $token = base64_encode(openssl_random_pseudo_bytes(5));
        Service::get('session')->set('token',$token);
        return $token;
    }
    public static function check($token){
        $ses_token = Service::get('session')->get('token');
        if(isset($ses_token) && $ses_token === $token ){
            Service::get('session')->delete('token');
            return true;
        }
        return false;
    }

}