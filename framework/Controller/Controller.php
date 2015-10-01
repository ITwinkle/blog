<?php
/**
 * Created by PhpStorm.
 * User: ihor
 * Date: 19.09.15
 * Time: 22:54
 */

namespace Framework\Controller;


use Framework\DI\Service;
use Framework\Response\ResponseRedirect;

class Controller
{
    public function redirect($url, $message = ''){
        return new ResponseRedirect($url);
    }

    public function render($path, $vars){
        return Service::get('view')->render($path,$vars);
    }

}