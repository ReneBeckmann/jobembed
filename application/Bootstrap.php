<?php

namespace Project;

use ITSB\Autoloader as Autoloader;
use ITSB\Exception as Exceptions;

class Bootstrap
{
    public function __construct()
    {
        /**
         * Change Dir to Application
         */
        chdir(dirname(__FILE__));

        /**
         * Autoloader laden
         */
        try {
            if (is_file($file = '../library/ITSB/Autoloader.php')) {
                require_once($file);

                $autoloader = new Autoloader();
                $autoloader->register();
            } else {
                throw new \Exception('Autoloader ITSB nicht gefunden');
            }
        } catch (\Exception $e) {
            echo $e->getMessage();
        }

        /**
         * Prüfen ob der Helper existiert
         */
        try {
            if (!class_exists('ITSB\Helper')) {
                throw new Exceptions\ClassNotFoundException('Helper');
            }
        } catch (Exceptions\ClassNotFoundException $e) {
            echo $e->getMessage();
        }
    }
}
