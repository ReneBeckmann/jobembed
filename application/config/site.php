<?php

use ITSB\Helper as Helper;

$config = array(

    /**
     * Einstellungen für Development ( Lokale Entwicklung )
     */
    'development' => array(
        // Site Base
        'base' => 'http://192.168.0.107/jobembed/',
        // Show Error
        'show_error' => TRUE,
    ),

    /**
     * Einstellungen für Production ( Live )
     * Es müssen nur die Einstellungen aufgeführt werden, welche abweichend von den Development-Einstellungen sind
     */
    'production' => array(
        // Site Base
        'base' => '//beispielseite.de/',
        // Hide Errors
        'show_error' => FALSE,
    )
);

// return Site Config
return (Helper::returnConfig($config));
