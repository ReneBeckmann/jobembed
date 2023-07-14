<?php

/**
 * Created by JetBrains PhpStorm.
 * User: Christian
 * Date: 14.04.13
 * Time: 11:29
 * To change this template use File | Settings | File Templates.
 */

namespace ITSB;

use Model\Tokensystem;

class Controller
{
    /**
     * Twig Loader
     */
    protected $loader;

    /**
     * Twig Environment
     */
    public $view;

    /**
     * Helper Class
     */
    protected $helper;

    /**
     * Twig Options
     */
    protected $twig_config;

    /**
     * TWIG laden
     */
    public function __construct()
    {
        $twig_options = array();

        /**
         * Load Twig Config
         */
        $this->twig_config = require_once(getcwd() . '/config/twig.php');

        /**
         * Twig Loader Filesystem - View Pfad
         * Twig braucht den kompletten Pfad
         */
        $this->loader = new \Twig_Loader_Filesystem(getcwd() . '/view');

        /**
         * Layout Pfad hinzufügen
         * Twig braucht den kompletten Pfad
         */
        $this->loader->addPath(getcwd() . '/view/' . LANG . '/layout');

        /**
         * Cache
         */
        if ($this->twig_config['cache'] == TRUE) {
            $twig_options['cache'] = getcwd() . $this->twig_config['cache_dir'];
        }

        /**
         * Twig Umgebung laden
         */
        $this->view = new \Twig_Environment($this->loader, $twig_options);


        $mysqli = new Mysql();
        $db = $mysqli->connect();

        $token = new Tokensystem();
        $token->date = date('Y-m-d H:i:s', strtotime('-1 hour'));
        $token->clearToken($db);
    }

    /**
     * @param $path_to_view  - ab dem Ordner /application/view/
     * @param array $options -
     * @param string $layout - ab dem Ordner /application/view/layout/
     *  mit 'nolayout' wird kein Layout geladen, zum Beispiel für Ajax
     */
    protected function render($path_to_view, $vars = array(), $layout = 'default.twig')
    {
        $site = Helper::requireOnce(getcwd() . '/config/site.php');

        /**
         * Layout laden
         */
        if ($layout == 'ajax' or $layout == 'nolayout') {

            /**
             * Nur Part laden
             */
            $vars_to_template = array();
        } else {

            /**
             * Layout Laden
             */
            $layout = $this->view->loadTemplate($layout);


            /**
             * Variablen, welche immer an Twig übergeben werden
             */
            $vars_to_template = array(
                'layout' => $layout,
                'web_base' => $site['base'],
                'lang'  => LANG,
                'controller' => CONTROLLER
            );
        }

        // Variablen aus Controller übergeben
        foreach ($vars as $key => $value) {
            $vars_to_template[$key] = $value;
        }

        /**
         * Seite anzeigen
         */
        $errorLog = ErrorLog::getInstance();

        // Wenn Error, aber keine Fehler vom Controller übergeben wurden -> Lade Error Controller
        // So bleibt die Steuerung der Fehler indem Error Controller
        if (count($errorLog->exceptions) > 0 and !isset($vars_to_template['errors'])) {

            $site = new \Controller\Error();
            $site->IndexAction();

            // Seite darstellen
        } else {

            $this->view->display($path_to_view, $vars_to_template);
        }
    }
}
