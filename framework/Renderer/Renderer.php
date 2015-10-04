<?php

namespace Framework\Renderer;

class Renderer
{
    public static  $renderPath;

    /**
     * path to  view
     *
     * @var string
     */
    private $layout = '';
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
        $this->layout = $view.$this->ext;

        if(!empty($vars)){
            $this->_vars = array_merge($this->_vars, $vars);
        }

        ob_start();
        extract($this->_vars);
        include $this->layout;
        return ob_get_clean();
    }
}