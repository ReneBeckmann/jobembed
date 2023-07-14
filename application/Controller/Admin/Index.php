<?php

namespace Controller\Admin;

use \ITSB\Controller;
use \ITSB\Mysql;
use \Model\User;


class Index extends Controller
{

    public function IndexAction()
    {

        $mysqli = new Mysql();
        $db = $mysqli->connect();

        if ($_SESSION['login'] == 'logged') {
            header("Location: admin/news/");
        }

        $login = new User();

        if (isset($_POST['sub_login'])) {
            $login->checkLogin($db, $_POST['username'], $_POST['password']);

            if ($login->error) {
                $error = $login->error;
            }
        }

        $this->render('/admin/index/index.twig', array(
            'error'     => $error
        ), 'admin.twig');
    }
}
