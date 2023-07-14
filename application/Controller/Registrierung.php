<?php

namespace Controller;

use \ITSB\Mysql;
use \ITSB\Mailer;
use \Model\User;

use \Model\Unternehmen  as ModelUnternehmen;
use \Model\Tokensystem  as ModelTokensystem;

class Registrierung extends \ITSB\Controller
{
    public function IndexAction()
    {
        $this->render('/' . LANG . '/registrierung/index.twig', array(), 'default.twig');
    }

    public function verifyAccountAction()
    {
        $token   = $_GET['hash'];

        $mysqli    = new Mysql();
        $db        = $mysqli->connect();

        $token = new ModelTokensystem();
        $token->token = $token;
        $token->verifyToken($db);

        $this->render('/' . LANG . '/registrierung/accountverified.twig', array(), 'default.twig');
    }

    public function registerAction()
    {
        if (!isset($_POST['sub_Anmelden'])) {
            return;
        }

        $mysqli = new Mysql();
        $db     = $mysqli->connect();


        $status = null;
        $error = '';
        $id_unternehmen = null;
        $token          = null;

        $unternehmen = new ModelUnternehmen();

        if (isset($_POST)) {
            if (isset($_POST['unternehmenName'])) {
                $unternehmen->name        = $_POST['unternehmenName'];
            }
            if (isset($_POST['strasse'])) {
                $unternehmen->strasse     = $_POST['strasse'];
            }
            if (isset($_POST['plz'])) {
                $unternehmen->plz         = $_POST['plz'];
            }
            if (isset($_POST['ort'])) {
                $unternehmen->ort         = $_POST['ort'];
            }
            if (isset($_POST['telefon'])) {
                $unternehmen->telefon     = $_POST['telefon'];
            }
            if (isset($_POST['fax'])) {
                $unternehmen->fax         = $_POST['fax'];
            }
            if (isset($_POST['email'])) {
                $unternehmen->email       = $_POST['email'];
            }
            if (isset($_POST['url'])) {
                $unternehmen->url         = $_POST['url'];
            }

            $apikey = $unternehmen->apiKeyGenerator($_POST['unternehmenName'] . '-');

            $unternehmen->apikey      = $apikey;
            $unternehmen->status      = 0;
            $unternehmen->verified    = 0;

            if ($unternehmen->save($db)) {
                //ID des Eintrags speichern
                $id_unternehmen = $db->insert_id;

                //Erstellung Token 
                $token = new ModelTokensystem();
                $token->id_unternehmen = $id_unternehmen;
                $token->art            = "VERIFY_TOKEN";
                $token->token          = str_replace('.', '_', uniqid('', true));
                $token->date           = date('Y-m-d:H:i:s');

                $token->save($db);

                // SEND MAIL 
                $email  = $_POST['email'];

                $mail = new Mailer();
                $mail->subject = "Bestätigung Ihrer Anmeldung";
                $mail->template = LANG . '/mailer/anmeldebestaetigung.twig';
                // EMPFÄNGERADRESSE
                $mail->toAddress = $email;
                // MITTEILUNG
                $mail->message = $this->view->render(
                    $mail->template,
                    array(
                        'token' => $token->token
                    )
                );
                // SENDEN
                $mail->send();

                $user = new User();
                if (isset($_POST['anrede'])) {
                    $user->anrede         = $_POST['anrede'];
                }
                if (isset($_POST['vorname'])) {
                    $user->vorname        = $_POST['vorname'];
                }
                if (isset($_POST['nachname'])) {
                    $user->nachname       = $_POST['nachname'];
                }
                if (isset($_POST['email'])) {
                    $user->email          = $_POST['email'];
                }
                if (isset($_POST['password'])) {
                    $user->password       = password_hash($_POST['password'], PASSWORD_DEFAULT);
                }

                $user->id_unternehmen = $id_unternehmen;
                $user->save($db);
            } else {
                $error = 'Es ist ein Fehler aufgetreten. Versuchen Sie es bitte erneut.';
            }

            $this->render('/' . LANG . '/registrierung/done.twig', array(
                'error' => $error
            ), 'default.twig');
        }
    }
}
