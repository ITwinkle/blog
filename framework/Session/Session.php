<?php

namespace Framework\Session;

class Session
{
    /**
     * @var string
     */
    public $returnUrl = '/';

    /**
     * Start Session
     */
    public function __construct(){
        session_start();
    }

    /**
     * Set value of Session var
     *
     * @param $name - name of Session var
     * @param $val
     */
    public function set($name,$val){
        $_SESSION[$name] = $val;
    }

    /**
     * Get Session var
     *
     * @param $name - name of Session var
     * @return mixed
     */
    public function get($name){
        return $_SESSION[$name]?$_SESSION[$name] : false;
    }

    /**
     * Delete var from Session
     * @param $name - name of Session var
     */
    public function delete($name){
        unset($_SESSION[$name]);
    }

    /**
     * Check session var
     *
     * @param $name - name of Session var
     * @return bool
     */
    public function isExist($name){
        return $_SESSION[$name]? true : false;
    }

}