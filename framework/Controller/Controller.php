<?php

namespace Framework\Controller;


use Framework\DI\Service;
use Framework\Response\Response;
use Framework\Response\ResponseRedirect;
use Framework\Renderer\Renderer;
use Framework\Application;
abstract class Controller
{
    public function redirect($url, $message = '',$type = 'OK'){
        if($message){
            Service::get('flush')->set($type,$message);
        }
        return new ResponseRedirect($url);

    }

    public function render($view, $vars){
        $class = explode('\\',static::class);
        $class =  substr($class[2],0,strpos($class[2],'Controller'));
        $view = Renderer::$renderPath.$class.'/'.$view;
        return  new Response(Service::get('renderer')->render(Application::$configs['main_layout'],
            array('content'=>Service::get('renderer')->render($view,$vars)))
        );
    }

    public function generateRoute($name){
        return Service::get('router')->generateRoute($name);
    }

    public function getRequest(){
        return Service::get('request');
    }

}