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
    static $prefixes = array();

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
    public static function addNamespace($alias, $dir, $prepend = false)
    {
        // normalize namespace prefix
        $alias = trim($alias, '\\') . '\\';
        // normalize the base directory with a trailing separator
        $dir = rtrim($dir, DIRECTORY_SEPARATOR) . '/';
        // initialize the namespace prefix array
        if (isset(self::$prefixes[$alias]) === false) {
            self::$prefixes[$alias] = array();
        }
        // retain the base directory for the namespace prefix
        if ($prepend) {
            array_unshift(self::$prefixes[$alias], $dir);
        } else {
            array_push(self::$prefixes[$alias], $dir);
        }

        Loader::register();
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
        // the current namespace alias
        $alias = $class;
        // work backwards through the namespace names of the fully-qualified
        // class name to find a mapped file name
        while (false !== $pos = strrpos($alias, '\\')) {
            // retain the trailing namespace separator in the alias
            $alias = substr($class, 0, $pos + 1);
            // the rest is the relative class name
            $relative_class = substr($class, $pos + 1);
            // try to load a mapped file for the alias and relative class
            $mapped_file = self::loadMappedFile($alias, $relative_class);
            if ($mapped_file) {
                return $mapped_file;
            }
            // remove the trailing namespace separator for the next iteration
            // of strrpos()
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
        // are there any base directories for this namespace prefix?
        if (isset(self::$prefixes[$alias]) === false) {
            return false;
        }
        // look through base directories for this namespace prefix
        foreach (self::$prefixes[$alias] as $dir) {
            // replace the namespace prefix with the base directory,
            // replace namespace separators with directory separators
            // in the relative class name, append with .php
            $file = $dir
                . str_replace('\\', '/', $relative_class)
                . '.php';
            // if the mapped file exists, require it
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
