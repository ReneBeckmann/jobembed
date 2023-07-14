<?php

namespace Model;

class Tokensystem
{
    public $id;
    public $id_unternehmen;
    public $id_user;
    public $art;
    public $token;
    public $date;

    public $status;
    public $error;

    public $ausgabe_query;
    public $ausgabe_array;

    public function save($db)
    {
        if ($db->query("
            INSERT INTO `tokensystem` (
                `id_unternehmen`,
                `id_user`,
                `art`,
                `token`,
                `date`
            ) 
            VALUES (
                '" . mysqli_real_escape_string($db, $this->id_unternehmen) . "',
                '" . mysqli_real_escape_string($db, $this->id_user) . "',
                '" . mysqli_real_escape_string($db, $this->art) . "',
                '" . mysqli_real_escape_string($db, $this->token) . "',
                '" . mysqli_real_escape_string($db, $this->date) . "'
            )
        ")) {
            return true;
        }
    }


    public function verifyToken($db)
    {
        $db->query("SELECT * FROM `tokensystem` WHERE `token` = '" . mysqli_real_escape_string($db, $this->token) . "' ");
    }


    public function clearToken($db)
    {
        $db->query("DELETE FROM `tokensystem` WHERE `date` < '" . mysqli_real_escape_string($db, $this->date) . "' ");
    }

    public function token_auslesen()
    {
        $this->ausgabe_array = array();
        while ($get_row = mysqli_fetch_assoc($this->ausgabe_query)) {
            $this->ausgabe_array[] = $get_row;
        }
    }
}
