<?php
session_start();



require('environment.php');

/**
 * Umgebungsvariable auslesen
 * wird in der .htaccess festgelegt
 */
try {

    if (empty($env)) {
        throw new Exception();
    }

    defined('ENVIRONMENT') or
        define('ENVIRONMENT', $env);
} catch (Exception $e) {
    die('Umgebungsvariable "ENVIRONMENT" nicht gefunden.
    Kontaktieren Sie bitte den Seitenbetreiber');
}

/**
 * Bootstrap laden
 * Autoloader & Helper
 */
try {
    $bootstrap_file = '../application/Bootstrap.php';

    if (!file_exists($bootstrap_file)) {
        throw new Exception();
    }

    require_once($bootstrap_file);
    $bootstrap = new Project\Bootstrap();
} catch (Exception $e) {
    die('Bootstrap konnte nicht gefunden werden.');
}

/**
 * Run...
 */
try {

    /**
     * Request Uri
     */
    $request = $_SERVER['REQUEST_URI'];

    /**
     * Language, Controller und Action
     */
    $language = 'de';
    $controller = 'Index';
    $action = 'Index';

    $root = str_replace('public/index.php', '', $_SERVER['SCRIPT_NAME']);

    $request = preg_replace('#^(' . $root . ')#', '', $request);

    $elements = explode('/', $request);

    // echo "<pre>";
    // print_r($elements);
    // echo "</pre>";

    //abfrage ob spracheauswahl oder adminbereich
    if (!empty($elements[0]) && ($elements[0] == 'de' ||  $elements[0] == 'en' ||  $elements[0] == 'dk')) {
        $language = $elements[0];

        //Controller
        if (!empty($elements[1]))
            $controller = ucfirst($elements[1]);
        //echo "<br> Controller mit Sprachauswahl: ". $controller. "<br>";
    } else {

        //Controller
        if (!empty($elements[0]))
            $controller = ucfirst($elements[0]);
        // echo "<br> Controller ohne Sprachauswahl: ". $controller. "<br>";
    }

    // Admin-Bereich wenn Url /admin/
    if ($controller == 'Admin') {
        $controller .= '\\';

        // Controller erweitern
        if (!empty($elements[1])) {
            $controller .= ucfirst($elements[1]);

            // Default index
        } else {
            $controller .= 'Index';
        }

        // $action bestimmen wenn ein nicht numerischer Wert übergeben wurde
        // z.B. admin/news/eintragen
        if (!empty($elements[2]) and !is_numeric($elements[2])) {
            $action = ucfirst($elements[2]);
            // $_GET[id] bestimmen wenn ein nummerischer Wert übergeben wurde
            // z.B. admin/news/321
            $_GET['id'] = $elements[3];
        } elseif (!empty($elements[2]) and is_numeric($elements[2])) {
            $_GET['id'] = $elements[2];
        }

        // Andernfalls Besucher-Bereich
    } else {
        // $action bestimmen wenn ein nicht numerischer Wert übergeben wurde
        // z.B. news/all
        if (!empty($elements[1]) and !is_numeric($elements[1])) {
            $action = ucfirst($elements[1]);
            // $_GET[id] bestimmen wenn ein nummerischer Wert übergeben wurde
            // z.B. news/321
        } elseif (!empty($elements[1]) and is_numeric($elements[1])) {
            $_GET['id'] = $elements[1];
        }

        if (!empty($elements[2]) and !is_numeric($elements[2])) {
            $action = ucfirst($elements[2]);
            // $_GET[id] bestimmen wenn ein nummerischer Wert übergeben wurde
            // z.B. news/321
        } elseif (!empty($elements[2]) and is_numeric($elements[2])) {
            $_GET['id'] = $elements[2];
        }

        if ($elements[0] == 'stellenangebote') {
            $action = 'Index';
            if (isset($elements[1])) {
                $_GET['id']   = $elements[1];
            }
        }

        // API CALL 
        if ($elements[0] == 'api') {
            $action     = ucfirst($elements[1]);
            if (isset($elements[2])) {
                $_GET['id']   = $elements[2];
            }
        }
    }

    $action .= 'Action';

    defined('LANG') or
        define('LANG', $language);

    defined('CONTROLLER') or
        define('CONTROLLER', $controller);

    defined('ACTION') or
        define('ACTION', $action);

    $controller = 'Controller\\' . $controller;

    if (!class_exists($controller)) {
        throw new ITSB\Exception\SiteNotFoundException('Seite nicht gefunden');
    }


    $site = new $controller;


    if (!method_exists($site, $action)) {
        throw new ITSB\Exception\SiteNotFoundException('Seite nicht gefunden');
    }

    $site->$action();




    /**
     * Fehlerbehandlung
     */
} catch (ITSB\Exception\FileNotFoundException $e) {
    $e->errorLog();
} catch (ITSB\Exception\ClassNotFoundException $e) {
    $e->errorLog();
} catch (ITSB\Exception\VarNotFoundException $e) {
    $e->errorLog();
} catch (ITSB\Exception\SiteNotFoundException $e) {
    $site = new Controller\Error;
    $site->SiteNotFoundAction();
}
