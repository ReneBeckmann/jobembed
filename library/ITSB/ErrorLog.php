<?php

/**
 * Singleton
 */

namespace ITSB;

class ErrorLog
{
    private static $instance;
    public $exceptions;

    private function __construct()
    {
        $this->exceptions = array();
    }

    public static function getInstance()
    {
        if (!isset(self::$instance)) {
            $className = __CLASS__;
            self::$instance = new $className;
        }
        return self::$instance;
    }

    public function addError(Exception $error)
    {
        $this->exceptions[] = $error;
    }

    public function __clone()
    {
        trigger_error('Clonen ist nicht erlaubt.');
    }

    public function __wakeup()
    {
        trigger_error('Deserialisierung ist nicht erlaubt.');
    }
}
