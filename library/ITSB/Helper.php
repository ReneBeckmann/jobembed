<?php

/**
 * Created by JetBrains PhpStorm.
 * User: christian
 * Date: 10.01.14
 * Time: 09:11
 * To change this template use File | Settings | File Templates.
 */

namespace ITSB;

class Helper
{
    /**
     * @param $var - Variable
     * @return mixed - Variable
     * @throws VarNotFoundException
     */
    public static function getValue($var)
    {

        if (!isset($var)) {
            throw new VarNotFoundException($var);
        }

        return $var;
    }

    /**
     * @param $file - Pfad zur Datei
     * @return mixed - Gibt die geladene Datei zurück (require_once $file)
     * @throws FileNotFoundException - Falls die Datei nicht gefunden wird.
     */
    public static function requireOnce($file)
    {

        if (!file_exists($file)) {
            throw new FileNotFoundException($file);
        }

        return (require($file));
    }

    /**
     * Return Config
     */
    public static function returnConfig($options)
    {
        /**
         * Prüfen ob in dem übergeben Array der Key 'development' definiert wurde
         */
        if (!isset($options['development'])) {

            throw new VarNotFoundException('development');
        }

        /**
         * Config laden nach der Einstellung von 'environment'
         */
        switch (ENVIRONMENT) {
            case 'development':
                return $options['development'];
            default:
                $key = ENVIRONMENT;
                return array_merge($options['development'], $options[$key]);
        }
    }
}
