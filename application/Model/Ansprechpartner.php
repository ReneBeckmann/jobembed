<?php

namespace Model;

class Ansprechpartner
{
    public $id;
    public $vorname;
    public $nachname;
    public $telefon;
    public $email;
    public $id_unternehmen;

    public $status;
    public $error;

    public $ausgabe_query;
    public $ausgabe_array;

    public function save($db)
    {
        if ($db->query("
            INSERT INTO `ansprechpartner` (
                `vorname`,
                `nachname`,
                `telefon`,
                `email`,
                `id_unternehmen`
            ) 
            VALUES (
                '" . mysqli_real_escape_string($db, $this->vorname) . "',
                '" . mysqli_real_escape_string($db, $this->nachname) . "',
                '" . mysqli_real_escape_string($db, $this->telefon) . "',
                '" . mysqli_real_escape_string($db, $this->email) . "',
                '" . mysqli_real_escape_string($db, $this->id_unternehmen) . "'
            )
        ")) {
            return true;
        }
    }

    public function delete($db)
    {
        $db->query("
            DELETE FROM `ansprechpartner` WHERE `id` = '" . mysqli_real_escape_string($db, $this->id) . "'
        ");
    }


    public function auslesen()
    {
        $this->ausgabe_array = array();
        while ($get_row = mysqli_fetch_assoc($this->ausgabe_query)) {
            $this->ausgabe_array[] = $get_row;
        }
    }
}
