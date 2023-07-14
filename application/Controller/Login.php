<?php

namespace Controller;

use \ITSB\Mysql;
use Model\Tokensystem;
use \Model\User;

class Login extends \ITSB\Controller
{
    public function IndexAction()
    {
        $error = null;
        $sessionToken = null;

        $mysqli = new Mysql();
        $db     = $mysqli->connect();

        if ($_SESSION['token']) {
            $id_user        = $_SESSION['id_user'];
            $id_unternehmen = $_SESSION['id_unternehmen'];
            $sessionToken   = $_SESSION['token'];

            $result = $db->query("SELECT `token` FROM `tokensystem` WHERE `art` = 'SESSION_TOKEN' AND `token` = '$sessionToken' AND `id_user` = $id_user AND `id_unternehmen` = $id_unternehmen");
            $row = $result->fetch_assoc();

            $row_cnt = $result->num_rows;

            if ($row_cnt != 0) {
                if ($row['token'] == $_SESSION['token']) {
                    header("Location: intern/meinestellen");
                }
            }
        }


        // if (isset($_SESSION['token']) && $_SESSION['token'] == 'logged') {
        //     header("Location: intern/meinestellen");
        // }

        if (isset($_POST['sub_login'])) {
            $login = new User();
            $sessionToken = uniqid('ST_', true);

            $login->checkLogin($db, $_POST['userMail'], $_POST['userPass'], $sessionToken);

            if ($login->login == true) {
                $token = new Tokensystem();
                $token->id_unternehmen  = $_SESSION['id_unternehmen'];
                $token->id_user         = $_SESSION['id_user'];
                $token->art             = 'SESSION_TOKEN';
                $token->token           = $sessionToken;
                $token->date            = date('Y-m-d H:i:s');
                $token->save($db);
                header("Location: intern/meinestellen/");
            }

            if ($login->error) {
                $error = $login->error;
            }
        }

        $this->render('/' . LANG . '/login/index.twig', array(
            'error'     => $error
        ), 'default.twig');
    }
}
