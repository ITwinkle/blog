<?php

namespace Framework\Security;

use Framework\DI\Service;

class Security
{
    private $user = 'user_name';

    /**
     * Set name of user
     *
     * @param String $name - name of user
     * @throws \Framework\Exception\DiException
     */
    public function setUser($name){
        Service::get('session')->set($this->user,json_encode($name));
    }

    /**
     * Check for Authenticate
     *
     * @return bool
     * @throws \Framework\Exception\DiException
     */
    public function isAuthenticated(){
        return Service::get('session')->isExist($this->user);
    }

    /**
     * Get user name
     *
     * @return string
     * @throws \Framework\Exception\DiException
     */
    public function getUser(){
        return json_decode(Service::get('session')->get($this->user));
    }

    /**
     * Delete current user
     *
     * @throws \Framework\Exception\DiException
     */
    public function clear(){
        Service::get('session')->delete($this->user);
    }

}