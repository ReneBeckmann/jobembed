<?php

namespace Model;

class Antworten
{
    public $id;
    public $antwort;
    public $id_frage;
    public $id_stelle;

    public $ausgabe_query;
    public $ausgabe_array;

    public function save($db)
    {
        $db->query("
            INSERT INTO `antworten` (
                `antwort`,
                `id_frage`,
                `id_stelle`
            ) 
            VALUES (
                '" . mysqli_real_escape_string($db, $this->antwort) . "',
                '" . mysqli_real_escape_string($db, $this->id_frage) . "',
                '" . mysqli_real_escape_string($db, $this->id_stelle) . "'
            )
        ");
    }

    public function update($db)
    {
        $db->query("
            UPDATE 
                `antworten` 
            SET 
                `antwort` = '" . mysqli_real_escape_string($db, $this->antwort) . "'
            WHERE 
                `id` = '" . mysqli_real_escape_string($db, $this->id) . "'
        ");
    }


    public function delete($db)
    {
        $db->query("
            DELETE 
            FROM 
                `antworten` 
            WHERE 
                `id` = '" . mysqli_real_escape_string($db, $this->id) . "'
        ");
    }


    public function deleteBulk($db)
    {
        $db->query("
            DELETE 
            FROM 
                `antworten` 
            WHERE 
                `id_frage` = '" . mysqli_real_escape_string($db, $this->id_frage) . "'
        ");
    }



    public function antworten_auslesen()
    {
        $this->ausgabe_array = array();
        while ($get_row = mysqli_fetch_assoc($this->ausgabe_query)) {
            $this->ausgabe_array[] = $get_row;
        }
    }
}
