<?php

/**
 * Autoloader
 *
 * @package framework
 * @version    1.0
 * @author     Ihor Anischenko <anishchenko.igor@gmail.com>
 * @copyright  2014 - 2015 Ihor Anischenko
 */
class Loader
{
    /**
     * An associative array where the key is a namespace prefix and the value
     * is an array of base directories for classes in that namespace.
     *
     * @var array
     */
    static $aliases = array();

    /**
     * Register loader with SPL autoloader stack.
     *
     * @return void
     */
    public static function register()
    {
        spl_autoload_register(array(self::class, 'loadClass'));
    }
    /**
     * Adds a base directory for a namespace prefix.
     *
     * @param string $alias The namespace prefix.
     * @param string $dir A base directory for class files in the
     * namespace.
     * @param bool $prepend If true, prepend the base directory to the stack
     * instead of appending it; this causes it to be searched first rather
     * than last.
     * @return void
     */
    public static function addNamespacePath($alias, $dir, $prepend = false)
    {
        $alias = trim($alias, '\\') . '\\';
        $dir = rtrim($dir, DIRECTORY_SEPARATOR) . '/';
        if (isset(self::$aliases[$alias]) === false) {
            self::$aliases[$alias] = array();
        }
        if ($prepend) {
            array_unshift(self::$aliases[$alias], $dir);
        } else {
            array_push(self::$aliases[$alias], $dir);
        }
    }
    /**
     * Loads the class file for a given class name.
     *
     * @param string $class The fully-qualified class name.
     * @return mixed The mapped file name on success, or boolean false on
     * failure.
     */
    public static function loadClass($class)
    {
        $alias = $class;
        while (false !== $pos = strrpos($alias, '\\')) {
            $alias = substr($class, 0, $pos + 1);
            $relative_class = substr($class, $pos + 1);
            $mapped_file = self::loadMappedFile($alias, $relative_class);
            if ($mapped_file) {
                return $mapped_file;
            }
            $alias = rtrim($alias, '\\');
        }
        return false;
    }
    /**
     * Load the mapped file for a namespace prefix and relative class.
     *
     * @param string $alias The namespace prefix.
     * @param string $relative_class The relative class name.
     * @return mixed Boolean false if no mapped file can be loaded, or the
     * name of the mapped file that was loaded.
     */
    protected static function loadMappedFile($alias, $relative_class)
    {
        if (isset(self::$aliases[$alias]) === false) {
            return false;
        }
        foreach (self::$aliases[$alias] as $dir) {
            $file = $dir
                . str_replace('\\', '/', $relative_class)
                . '.php';
            if (self::requireFile($file)) {
                return $file;
            }
        }
        return false;
    }
    /**
     * If a file exists, require it from the file system.
     *
     * @param string $file The file to require.
     * @return bool True if the file exists, false if not.
     */
    protected static function requireFile($file)
    {
        if (file_exists($file)) {
            require $file;
            return true;
        }
        return false;
    }
}
Loader::register();