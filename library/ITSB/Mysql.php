<?php

namespace ITSB;

class Mysql
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
        $connection = mysqli_connect($this->host, $this->user, $this->password, $this->database);
        if (mysqli_connect_errno($connection)) {

            echo "Failed to connect to MySQL: " . mysqli_connect_error();
        }

        $connection->set_charset('utf8');
        return ($connection);
    }
}
