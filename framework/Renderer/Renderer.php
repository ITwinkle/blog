<?php

namespace Framework\Renderer;

use Framework\Application;
use Framework\DI\Service;

class Renderer
{
    public static  $renderPath;

    private $view = '';

    /**
     * array of params of view
     *
     * @var array
     */
    private $_vars = array();
    /**
     * extension of file
     *
     * @var string
     */
    public $ext = '.php';

    public function __construct(){
        static::$renderPath = ROOT.'src/Blog/views/';
        $this->set('include',
            function ($controller, $action, $params) {
                $ctrl = new $controller;
                $action .= 'Action';
                return call_user_func_array(array($ctrl, $action), $params);
            }
        );
        $this->set('flush', Service::get('flush')->show());
        $this->set('user',Service::get('security')->getUser()?Service::get('security')->getUser():null);
        $this->set('route',Service::get('router')->getActiveRoute());
        $this->set('getRoute',function($name){return Service::get('router')->generateRoute($name);} );
        $this->set('generateToken',function(){return Service::get('noCrsf');});

    }

    /**
     * initialize variables of view
     *
     * @param string $var   - name of variable
     * @param string $value - value of variable
     *
     * @return object
     */
    public function set($var, $value = '')
    {
        if (is_array($var)) {
            $this->_vars = array_merge($this->_vars, $var);
        } else {
            $this->_vars[$var] = $value;
        }
        return $this;
    }
    /**
     * setter
     *
     * @param string $var   - name of variable
     * @param string $value - value of variable
     *
     * @return void
     */
    public function __set($var, $value)
    {
        $this->_vars[$var] = $value;
    }

    /**
     * render output data
     *
     * @param string $view - path to view
     * @param $vars - params
     * @return string
     */
    public function render($view, $vars = '')
    {
        if($view == Application::$configs['main_layout']){
            $this->view = $view;
        }elseif($view == Application::$configs['error_500']){
            $this->view = $view;
        }else {
            $this->view = $view . $this->ext;
        }
        if(!empty($vars)){
            $this->_vars = array_merge($this->_vars, $vars);
        }

        ob_start();
        extract($this->_vars);
        include $this->view;
        return ob_get_clean();
    }
}