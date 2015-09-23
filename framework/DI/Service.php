<?php

namespace Framework\DI;


class Service
{
    /**
     * dependency injection container
     *
     * @var array
     */
    protected static $di = array();
    /**
     * @param string $name   - alias of object
     * @param string $object - name of object
     *
     * @return void
     */
    public static function set($name, $object)
    {
        self::$di[$name] = $object;
    }
    /**
     * @param string $name - alias of object
     *
     * @return mixed
     */
    public static function get($name)
    {
        if (isset(self::$di[$name])) {
            if (self::$di[$name] instanceof \Closure) {
                $class = call_user_func(self::$di[$name]);
            } else {
                $class = self::$di[$name];
            }
            return $class;
        } else {
            exit('ERROR');
        }
    }
    /**
     * setter
     *
     * @param $name   - alias of object
     * @param $object - name of object
     *
     * @return void
     */
    public function __set($name, $object)
    {
        $this->set($name, $object);
    }
    /**
     * getter
     *
     * @param $name - alise of object
     *
     * @return void
     */
    public function __get($name)
    {
        $this->get($name);
    }
}