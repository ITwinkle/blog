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
     * current route
     *
     * @var string
     */
    private $activeRoute;

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
     * set rules of route and return array of routes
     *
     * @return array
     */
    public function getRoute()
    {
        $uri = '/' . trim(Service::get('request')->getUri(), '/');
        foreach ($this->routes as $name => $route) {
            $pattern = str_replace(array('{', '}'), array('(?P<', '>)'), $route['pattern']);
            if (array_key_exists('_requirements', $route)) {
                if (array_key_exists(
                        '_method',
                        $route['_requirements']
                    ) && $route['_requirements']['_method'] != Service::get('request')->getMethod()
                ) {
                    continue;
                }
                if (0 !== count($route['_requirements'])) {
                    $search = $replace = array();
                    foreach ($route['_requirements'] as $key => $value) {
                        $search[] = '<' . $key . '>';
                        $replace[] = '<' . $key . '>' . $value;
                    }
                    $pattern = str_replace($search, $replace, $pattern);
                }
            }
            if (!preg_match('~^' . $pattern . '$~', $uri, $params)) {
                continue;
            }
            $params = array_merge(array('controller' => $route['controller'], 'action' => $route['action']), $params);
            foreach ($params as $key => $value) {
                if (is_int($key)) {
                    unset($params[$key]);
                }
            }
            $this->activeRoute = array('_name'=>$name);
            return $params;
        }
    }

    /**
     *Generate specific uri
     *
     *@return array
     */
    public function generateRoute($name){
        if(array_key_exists($name,$this->routes)){
            return $this->routes[$name]['pattern'];
        }
        return false;
    }

    /**
     * return active route
     *
     * @return mixed
     */
    public function getActiveRoute(){
        return $this->activeRoute;
    }
}