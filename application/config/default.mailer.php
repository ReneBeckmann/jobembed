<?php

use ITSB\Helper as Helper;

$config = array(

    /**
     * Einstellungen für Development ( Lokale Entwicklung )
     */
    'development' => array(

        // Formatierung
        'html'          => TRUE,
        'charset'       => 'utf-8',

        // Absender
        'from'          => ' ',
        'fromAddress'   => '',

        // Empfänger
        'toAddress'     => '',

        // SMTP
        'smtp' => array(
            'activate'  => TRUE,
            'host'      => 'smtp.mailtrap.io', // hier den smtp server eintragen
            'auth'      => TRUE,
            'user'      => '2a885677245ed2',
            'password'  => '8f992b41ba851b'
        ),

        // Standard Template ( ausgehend vom /view/ Ordner )
        'template'      => LANG . '/mailer/default.twig'
    ),

    /**
     * Einstellungen für Production ( Live )
     * Es müssen nur die Einstellungen aufgeführt werden, welche abweichend von den Development-Einstellungen sind
     */
    'production' => array(
        'smtp' => array(
            'activate' => FALSE
        )
    )
);

// return Mailer Config
return (Helper::returnConfig($config));
