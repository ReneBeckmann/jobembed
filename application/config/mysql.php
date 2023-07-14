<?php

use ITSB\Helper as Helper;

$config = array(

    /**
     * Einstellungen für Development ( Lokale Entwicklung )
     */
    'development' => array(
        'host'      => 'localhost',
        'user'      => 'root',
        'password'  => 'admin',
        'database'  => 'jprb'
    ),


    /**
     * Einstellungen für Production ( Live )
     * Es müssen nur die Einstellungen aufgeführt werden, welche abweichend von den Development-Einstellungen sind
     */
    'production' => array(
        'host'      => '',
        'user'      => '',
        'password'  => '',
        'database'  => ''
    )
);

// return Mysql Config
return (Helper::returnConfig($config));
