<?php

namespace ITSB;

class Pdo
{


    private $host;

    private $user;

    private $password;

    private $database;

    public function __construct()
    {

        $settings = Helper::requireOnce(getcwd() . '/config/mysql.php');

        $this->host = $settings['host'];
        $this->user = $settings['user'];
        $this->password = $settings['password'];
        $this->database = $settings['database'];
    }


    public function connect()
    {
        try {
            $connStr = 'mysql:host=' . $this->host . ';dbname=' . $this->database; //Ligne 1
            $arrExtraParam = array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"); //Error is in this line
            $pdo = new PDO($connStr, $this->user, $this->pass, $arrExtraParam);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            $msg = 'ERREUR PDO dans ' . $e->getFile() . ' L.' . $e->getLine() . ' : ' . $e->getMessage();
            die($msg);
        }
    }
}
