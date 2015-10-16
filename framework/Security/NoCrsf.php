<?php

namespace Framework\Security;

use Framework\DI\Service;

class NoCrsf
{
    /**
     * Generate name of token and return this name
     *
     * @return string
     * @throws \Framework\Exception\DiException
     */
    public static function generate(){
        $token = base64_encode(openssl_random_pseudo_bytes(5));
        Service::get('session')->set('token',$token);
        return $token;
    }

    /**
     * Check for valid token
     *
     * @param string $token - name of token
     * @return bool
     * @throws \Framework\Exception\DiException
     */
    public static function check($token){
        $ses_token = Service::get('session')->get('token');
        if(isset($ses_token) && $ses_token === $token ){
            Service::get('session')->delete('token');
            return true;
        }
        return false;
    }

}