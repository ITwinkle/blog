<?php

namespace Framework\Controller;


use Framework\DI\Service;
use Framework\Response\ResponseRedirect;

abstract class Controller
{
    public function redirect($url, $message = ''){
        return new ResponseRedirect($url);
    }

    public function render($view, $vars){
        //return Service::get('renderer')->render($view,$vars);
    }

    public function generateRoute(){

    }

}