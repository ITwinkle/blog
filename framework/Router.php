<?php

/**
 * Class Router
 *
 * @package framework
 * @version    1.0
 * @author     Ihor Anischenko <anishchenko.igor@gmail.com>
 * @copyright  2014 - 2015 Ihor Anischenko
 */

namespace Framework;

use Framework\DI\Service;

class Router
{
    /**
     * array of routes
     *
     * @var array
     */
    private $_routes = array();
    /**
     * current controller
     *
     * @var mixed
     */
    private $controller;
    /**
     * current action
     *
     * @var mixed
     */
    private $action;

    /**
     * @var
     */
    private $requirements = [];

    /**
     * @var
     */
    private $security;

    /**
     * @param $routes array - array of rules,controllers,actions,params.
     *
     *
     * @return object Router
     */
    public function set(array $routes)
    {
        $this->_routes = array_merge($this->_routes, $routes);
        return $this;
    }
    /**
     * set rules of route
     *
     * @param string $uri
     *
     * @return mixed, false if route was not found
     */
    public function getRoute()
    {
        $routes = $this->_routes;
        $uri    = '/'.trim(Service::get('request')->getUri(), '/');
        foreach($routes as $route){
            if($route['pattern'] === $uri){
                $this->controller = $route['controller'];
                $this->action = $route['action'];
                if (!empty($this->requirements)) {
                    $this->requirements = $route['_requirements'];
                }
                if (!empty($this->security)) {
                    $this->security = $route['security'];
                }
            }
        }
        return array(
            'controller' => $this->controller,
            'action'     => $this->action,
            '_requirements' => $this->requirements,
            'security' => $this->security
        );
    }

    /**
     *
     *
     *@return array
     */
    public function generateRoute($name){
        $routes = $this->_routes;

        foreach($routes as $key => $value){
            if($key === $name){
                $this->controller = $value['controller'];
                $this->action = $value['action'];
                if (!empty($this->requirements)) {
                    $this->requirements = $value['_requirements'];
                }
                if (!empty($this->security)) {
                    $this->security = $value['security'];
                }
            }
        }
        return array(
            'controller' => $this->controller,
            'action'     => $this->action,
            '_requirements' => $this->requirements,
            'security' => $this->security
        );
    }


    /**
     * return current controller
     *
     * @return mixed
     */
    public function getController()
    {
        return $this->controller;
    }
    /**
     * return current action
     *
     * @return mixed
     */
    public function getAction()
    {
        return $this->action;
    }
}