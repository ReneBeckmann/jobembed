<?php

namespace Model;

class Branchen
{
    public $id;
    public $name;

    public $status;
    public $error;

    public $ausgabe_query;
    public $ausgabe_array;

    public function save($db)
    {
        if ($db->query("
            INSERT INTO `branchen` (
                `name`
            ) 
            VALUES (
                '" . mysqli_real_escape_string($db, $this->name) . "'
            )
        ")) {
            return true;
        }
    }

    public function delete($db)
    {
        $db->query("
            DELETE FROM `branchen` WHERE `id` = '" . mysqli_real_escape_string($db, $this->id) . "'
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
