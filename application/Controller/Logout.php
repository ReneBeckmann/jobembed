<?php

namespace Controller;

use \ITSB\Mysql;
use \Model\User;

class Logout extends \ITSB\Controller
{
    public function IndexAction()
    {
        $mysqli = new Mysql();
        $db     = $mysqli->connect();

        $sessionToken = $_SESSION['token'];

        $logout = new User();
        $logout->logout($db, $sessionToken);
    }
}
