<?php

namespace Framework\Security;

use Framework\DI\Service;

class Security
{
    private $user = 'user_name';

    public function setUser($name){
        Service::get('session')->set($this->user,json_encode($name));
    }

    public function isAuthenticated(){
        return Service::get('session')->isExist($this->user);
    }

    public function getUser(){
        return json_decode(Service::get('session')->get($this->user));
    }

    public function clear(){
        Service::get('session')->delete($this->user);
    }

}