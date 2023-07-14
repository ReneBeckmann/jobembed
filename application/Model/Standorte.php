<?php

namespace Model;

class Standorte
{
    public $id;
    public $strasse;
    public $plz;
    public $ort;
    public $id_unternehmen;

    public $status;
    public $error;

    public $ausgabe_query;
    public $ausgabe_array;

    public function save($db)
    {
        if ($db->query("
            INSERT INTO `standorte` (
                `strasse`,
                `plz`,
                `ort`,
                `id_unternehmen`
            ) 
            VALUES (
                '" . mysqli_real_escape_string($db, $this->strasse) . "',
                '" . mysqli_real_escape_string($db, $this->plz) . "',
                '" . mysqli_real_escape_string($db, $this->ort) . "',
                '" . mysqli_real_escape_string($db, $this->id_unternehmen) . "'
            )
        ")) {
            return true;
        }
    }

    public function delete($db)
    {
        $db->query("
            DELETE FROM `standorte` WHERE `id` = '" . mysqli_real_escape_string($db, $this->id) . "'
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
