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
    private $routes = array();
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
        $this->routes = array_merge($this->routes, $routes);
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
        $uri = '/' . trim(Service::get('request')->getUri(), '/');
        foreach ($this->routes as $route) {
            $pattern = str_replace(array('{', '}'), array('(?P<', '>)'), $route['pattern']);
            if (array_key_exists('_requirements', $route)) {
                if (0 !== count($route['_requirements'])) {
                    $search = $replace = array();
                    foreach ($route['_requirements'] as $key => $value) {
                        $search[] = '<' . $key . '>';
                        $replace[] = '<' . $key . '>' . $value;
                    }
                    $pattern = str_replace($search, $replace, $pattern);
                }
            }
            if (!preg_match('&^' . $pattern . '$&', $uri, $params)) {
                continue;
            }
            $params = array_merge(array('controller' => $route['controller'], 'action' => $route['action']), $params);
            foreach ($params as $key => $value) {
                if (is_int($key)) {
                    unset($params[$key]);
                }
            }
            return $params;
        }
    }

    /**
     *
     *
     *@return array
     */
    public function generateRoute($name){
        $routes = $this->routes;

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
        return $this->controller.'/'.$this->action.'Action';
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