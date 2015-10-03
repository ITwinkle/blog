<?php

namespace Framework;
use Framework\DI\Service;
use Framework\Exception\HttpException;
use Framework\Response\JsonRespose;
use Framework\Response\Response;
use Framework\Response\ResponseInterface;

class Application
{
    /**
     * configurations of project
     *
     * @var array|mixed
     */
    private $configs = [];

    public function __construct($conf){
        $this->configs = include $conf;
        $this->devMod();
        Service::set('request',new \Framework\Request\Request());
        Service::set('renderer', new \Framework\Renderer\Renderer());
       // Service::set('session',new Framework\Session\Session());
       // Service::set('security',new Framework\Security\Security());
        try {
            Service::set('pdo', new \PDO($this->configs['pdo']['dns'], $this->configs['pdo']['user'], $this->configs['pdo']['password']));
        }catch (\PDOException $e){
            echo "Wrong connection: " . $e->getMessage();
        }
       }

    public function devMod(){
        if($this->configs['mode'] === 'dev'){
            ini_set('error_reporting', E_ALL);
            ini_set('display_errors', 1);
            ini_set('display_startup_errors', 1);
        }else{
            ini_set('error_reporting', 0);
            ini_set('display_errors', 0);
            ini_set('display_startup_errors', 0);
        }
    }
    public function run(){

        $route = new Router();
        $route->set($this->configs['routes']);

        $route = $route->getRoute();
        $controllerClass = $route['controller'];
        $actionClass = $route['action'].'Action';
        try{
        if (class_exists($controllerClass)) {
            $refl = new \ReflectionClass($controllerClass);
        } else {
            throw new HttpException('No such controller', 404);
        }
        if ($refl->hasMethod($actionClass)) {
            $controller     = $refl->newInstance();
            $action         = $refl->getMethod($actionClass);
            unset($route['controller'],$route['action']);
            $response = $action->invokeArgs($controller,$route);
            if($response instanceof ResponseInterface) {
                $response->send();
            }
        } else {
            throw new HttpException('No such method', 404);
        }
        }catch (HttpException $e){
            echo $e->getMessage(). '\n file: '.$e->getFile(). '\n line: '.$e->getLine();
        }
    }
}