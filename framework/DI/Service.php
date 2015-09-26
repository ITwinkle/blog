<?php

namespace Framework\DI;

use Framework\Exception\DiException;

class Service
{
    /**
     * dependency injection container
     *
     * @var array
     */
    protected static $services = array();
    /**
     * @param string $name   - alias of object
     * @param string $object - name of object
     *
     * @return void
     */
    public static function set($name, $object)
    {
        self::$services[$name] = $object;
    }
    /**
     * @param string $name - alias of object
     *
     * @return mixed
     */
    public static function get($name)
    {
        if (isset(self::$services[$name])) {
            if (self::$services[$name] instanceof \Closure) {
                $class = call_user_func(self::$services[$name]);
            } else {
                $class = self::$services[$name];
            }
            return $class;
        } else {
            throw new DiException('No such service in container');
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