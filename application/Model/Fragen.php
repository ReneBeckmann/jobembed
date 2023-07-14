<?php

namespace Model;

class Fragen
{
    public $id;
    public $frage;
    public $type;
    public $id_unternehmen;
    public $id_stelle;
    public $position;

    public $ausgabe_query;
    public $ausgabe_array;

    public function save($db)
    {
        $db->query("
            INSERT INTO `fragen` (
                `frage`,
                `type`,
                `id_unternehmen`,
                `id_stelle`,
                `position`
            ) 
            VALUES (
                '" . mysqli_real_escape_string($db, $this->frage) . "',
                '" . mysqli_real_escape_string($db, $this->type) . "',
                '" . mysqli_real_escape_string($db, $this->id_unternehmen) . "',
                '" . mysqli_real_escape_string($db, $this->id_stelle) . "',
                '" . mysqli_real_escape_string($db, $this->position) . "'
            )
        ");
    }

    public function update($db)
    {
        $db->query("
            UPDATE 
                `fragen` 
            SET 
                `frage` = '" . mysqli_real_escape_string($db, $this->frage) . "'
            WHERE 
                `id` = '" . $this->id . "'
        ");
    }

    public function updatePosition($db)
    {
        $db->query("
            UPDATE 
                `fragen` 
            SET 
                `position` = '" . mysqli_real_escape_string($db, $this->position) . "'
            WHERE 
                `id` = '" . $this->id . "'
        ");
    }

    public function delete($db)
    {
        $db->query("
            DELETE FROM `fragen` WHERE `id` = '" . mysqli_real_escape_string($db, $this->id) . "'
        ");
    }


    public function fragen_auslesen()
    {
        $this->ausgabe_array = array();
        while ($get_row = mysqli_fetch_assoc($this->ausgabe_query)) {
            $this->ausgabe_array[] = $get_row;
        }
    }
}
