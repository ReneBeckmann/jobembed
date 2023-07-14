<?php

use ITSB\Helper as Helper;

$config = array(

    /**
     * Einstellungen für Development ( Lokale Entwicklung )
     */
    'development' => array(
        // Template Verzeichnis
        'template_dir' =>   'view/',

        // Layout Verzeichnis
        'layout_dir' =>  'view/layout',

        // Cache Einstellungen
        'cache' => FALSE,
        'cache_dir' => 'view/cache', // muss schreibbar sein!
    ),


    /**
     * Einstellungen für Production ( Live )
     * Es müssen nur die Einstellungen aufgeführt werden, welche abweichend von den Development-Einstellungen sind
     */
    'production' => array(
        // Cache Einstellungen
        'cache' => FALSE,
    )
);


// return Twig Config
return (Helper::returnConfig($config));
