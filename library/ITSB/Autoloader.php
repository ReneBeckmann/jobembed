<?php

namespace ITSB;

class Autoloader
{
    /**
     * Register Autoloader
     */
    public function register()
    {
        spl_autoload_register(array(new self, 'autoload'));
    }

    /**
     * @param $class
     * Autoloading for Controller, Model, Library
     */
    public function autoload($class)
    {
        /**
         * Library
         */
        if (is_file($file = dirname(__FILE__) . '/../' . str_replace('\\', '/', $class) . '.php')) {
            require $file;

            /**
             * Controller
             */
        } elseif (is_file($file = dirname(__FILE__) . '/../../application/' . str_replace('\\', '/', $class) . '.php')) {
            require $file;
        }

        /**
         * Library Twig
         */
        elseif (is_file($file = dirname(__FILE__) . '/../' . str_replace(array('_', "\\"), '/', $class) . '.php')) {
            require $file;
        } else {
            throw new Exception\ClassNotFoundException($class);
        }
    }
}
