<?php

namespace Model;

class User
{
    public $id_unternehmen;
    public $anrede;
    public $vorname;
    public $nachname;
    public $email;
    public $password;
    public $status;

    public $error;
    public $login;

    public function checkSession($db, $sessionToken)
    {
        if ($sessionToken) {
            $id_user        = $_SESSION['id_user'];
            $id_unternehmen = $_SESSION['id_unternehmen'];

            $result = $db->query(
                "SELECT 
                    `token` 
                FROM 
                    `tokensystem` 
                WHERE 
                    `art`            = 'SESSION_TOKEN' AND 
                    `token`          = '$sessionToken' AND 
                    `id_user`        = $id_user AND 
                    `id_unternehmen` = $id_unternehmen
                "
            );

            $row = $result->fetch_assoc();

            $row_cnt = $result->num_rows;
            if ($row_cnt == 0) {
                header("Location: //192.168.0.107/jobembed/login");
            } else {
                if ($row['token'] != $sessionToken) {
                    header("Location: //192.168.0.107/jobembed/login");
                } else {

                    $date = date('Y-m-d H:i:s');

                    $db->query(
                        "UPDATE 
                            `tokensystem` 
                        SET 
                            `date` = '$date'
                        WHERE
                            `token`          = '$sessionToken' AND
                            `id_user`        = $id_user AND
                            `id_unternehmen` = $id_unternehmen
                        "
                    );
                }
            }
        } else {
            header("Location: //192.168.0.107/jobembed/login");
        }
    }

    public function checkLogin($db, $email, $password, $sessionToken)
    {
        $result = $db->query(
            "SELECT 
                user.*,
                unternehmen.status
            FROM 
                `user` 
            LEFT JOIN
                `unternehmen`
            ON
                user.id_unternehmen = unternehmen.id
            WHERE 
                user.email = '$email'
        "
        );

        //Überprüfen ob der Benutzername vorhanden ist
        $row_cnt = $result->num_rows;

        if ($row_cnt == 0) {
            $this->error = 'E-Mail Adresse nicht vorhanden';
        } else {
            $row = $result->fetch_assoc();
            if (password_verify($password, $row['password'])) {

                $_SESSION['token']          = $sessionToken;
                $_SESSION['id_unternehmen'] = $row['id_unternehmen'];
                $_SESSION['status']         = $row['status'];
                $_SESSION['id_user']        = $row['id'];
                $_SESSION['vorname']        = $row['vorname'];
                $_SESSION['nachname']       = $row['nachname'];
                $_SESSION['email']          = $row['email'];
                $this->login = true;
            } else {
                $this->login = false;
                $this->error = 'Passwort falsch.';
            }
        }
    }

    public function save($db)
    {
        $db->query("
            INSERT INTO `user` (
                `id_unternehmen`,
                `anrede`,
                `vorname`,
                `nachname`,
                `email`,
                `password`
            ) 
            VALUES (
                '" . mysqli_real_escape_string($db, $this->id_unternehmen) . "',
                '" . mysqli_real_escape_string($db, $this->anrede) . "',
                '" . mysqli_real_escape_string($db, $this->vorname) . "',
                '" . mysqli_real_escape_string($db, $this->nachname) . "',
                '" . mysqli_real_escape_string($db, $this->email) . "',
                '" . mysqli_real_escape_string($db, $this->password) . "'
        
            )
        ");
    }


    public function logout($db, $sessionToken)
    {
        $db->query("DELETE FROM `tokensystem` WHERE `art` = 'SESSION_TOKEN' AND `token` = '$sessionToken'");

        session_destroy();
        header("Location: index/");
    }
}
