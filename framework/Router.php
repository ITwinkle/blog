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
    private $_controller;
    /**
     * current action
     *
     * @var mixed
     */
    private $_action;
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
    public function getRoute($uri)
    {
        $routes = $this->_routes;
        $uri    = '/'.trim($uri, '/');
        foreach($routes as $routes){
            if($routes['pattern'] === $uri){
                $this->_controller = $routes['controller'];
                $this->_action = $routes['action'];
            }
        }
        return array(
            'controller' => $this->_controller,
            'action'     => $this->_action,
        );
    }

    /**
     *
     * 
     */
    public function generateRoute($name){

    }
    /**
     * return current controller
     *
     * @return mixed
     */
    public function getController()
    {
        return $this->_controller;
    }
    /**
     * return current action
     *
     * @return mixed
     */
    public function getAction()
    {
        return $this->_action;
    }
}