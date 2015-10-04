<?php

namespace Framework\Renderer;

use Framework\Application;

class Renderer
{
    public static  $renderPath;

    /**
     * base layout
     *
     * @var string
     */
    private $layout = '';

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
        $this->layout = Application::$configs['main_layout'];
        static::$renderPath = ROOT.'src/Blog/views/';
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
        $this->view = $view.$this->ext;

        if(!empty($vars)){
            $this->_vars = array_merge($this->_vars, $vars);
        }

        ob_start();
        extract($this->_vars);
        include $this->view;
        $content =  ob_get_clean();

        return include($this->layout);
    }
}