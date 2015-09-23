<?php

namespace Framework\Request;
/**
 * Class Request
 *
 * @package    framework
 * @version    1.0
 * @author     Ihor Anischenko <anishchenko.igor@gmail.com>
 * @copyright  2014 - 2015 Ihor Anischenko
 */
class Request
{
    /**
     *handled associative array of variables passed to the current script via the HTTP GET method
     *
     * @var array
     */
    protected $get;
    /**
     * handled associative array of variables passed to the current script via the HTTP POST method
     *
     * @var array
     */
    protected $post;
    /**
     * handled associative array of variables passed to the current script via the HTTP SERVER
     *
     * @var array
     */
    protected $server;
    /**
     * which request method was used to access the page
     *
     * @var string
     */
    protected $method;

    /**
     * requested uri
     * @var string
     */
    protected $rUri;

    /**
     * @var string - host
     */
    protected $host;
    /**
     * initiation
     */
    public function __construct()
    {
        array_walk_recursive($_POST, trim);
        array_walk_recursive($_GET, trim);
        array_walk_recursive($_SERVER, trim);
        $this->get    = $_GET;
        $this->post   = $_POST;
        $this->server = $_SERVER;
        $this->method = $_SERVER['REQUESTED_METHOD'];
        $this->host = $_SERVER['HTTP_HOST'];
        $this->rUri = $_SERVER['REQUEST_URI'];
    }
    /**
     * return which request method was used to access the page
     *
     * @return string
     */
    public function getMethod()
    {
        return $this->method;
    }

    public function getUri(){
        return $this->rUri;
    }

    /**
     * return HTTP host
     *
     * @return string
     */
    public function getHost()
    {
        return $this->host;
    }
    /**
     * check for requested method is GET
     *
     * @return bool (true if requested method was used to access to page is GET)
     */
    public function isGet()
    {
        return 'GET' == $this->getMethod();
    }
    /**
     * check for requested method is POST
     *
     * @return bool (true if requested method was used to access to page is GET)
     */
    public function isPost()
    {
        return 'POST' == $this->getMethod();
    }
    /**
     * check for  HTTPS protocol
     *
     * @return bool (true if user use a  secure communication)
     */
    public function isHTTPS()
    {
        return (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || $_SERVER['SERVER_PORT'] == 443;
    }
    /**
     * return value of $key of global array GET if $key is not false
     * return global array GET if $key is false
     * return false if $key was not found in global array GET
     *
     * @param string $key
     *
     * @return mixed
     */
    public function get($key = false)
    {
        return ($key)?(isset($this->get[$key])?$this->get[$key]:false):$this->get;
    }
    /**
     * return value of $key of global array POST if $key is not false
     * return global array POST if $key is false
     * return false if $key was not found in global array POST
     *
     * @param string $key
     *
     * @return mixed
     */
    public function post($key = false)
    {
        return ($key)?(isset($this->post[$key])?$this->post[$key]:false):$this->post;
    }
    /**
     * return value of $key of global array GET if $key is not false
     * return global array GET if $key is false
     * return false if $key was not found in global array GET
     *
     * @param string $key
     *
     * @return mixed
     */
    public function getServer($key = false)
    {
        return ($key)?(isset($this->server[$key])?$this->server[$key]:false):$this->server;
    }
    /**
     * return headers
     *
     * @param $header - name of header
     *
     * @return string(bool if no such header in global array SERVER)
     */
    public function getHeader($header)
    {
        $header = 'HTTP_'.strtoupper($header);
        if (isset($_SERVER[$header])) {
            return $_SERVER[$header];
        }
        return null;
    }
}