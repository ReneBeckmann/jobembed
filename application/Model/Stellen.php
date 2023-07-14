<?php

namespace Model;

class Stellen
{
    public $id;
    public $id_unternehmen;
    public $id_user;
    public $id_stellenart;
    public $id_ansprechpartner;
    public $id_standort;

    public $name;
    public $beschreibung;
    public $start_date;
    public $visible;
    public $slug;
    public $created_at;
    public $modified_at;

    public $error;

    public $ausgabe_query;
    public $ausgabe_array;

    public function save($db)
    {
        $db->query("
            INSERT INTO `stellen` (
                `id_unternehmen`,
                `id_user`,
                `id_stellenart`,
                `id_ansprechpartner`,
                `id_standort`,
                `name`,
                `beschreibung`,
                `start_date`,
                `visible`,
                `slug`,
                `created_at`,
                `modified_at`
            ) 
            VALUES (
                '" . mysqli_real_escape_string($db, $this->id_unternehmen) . "',
                '" . mysqli_real_escape_string($db, $this->id_user) . "',
                '" . mysqli_real_escape_string($db, $this->id_stellenart) . "',
                '" . mysqli_real_escape_string($db, $this->id_ansprechpartner) . "',
                '" . mysqli_real_escape_string($db, $this->id_standort) . "',
                '" . mysqli_real_escape_string($db, $this->name) . "',
                '" . mysqli_real_escape_string($db, $this->beschreibung) . "',
                '" . mysqli_real_escape_string($db, $this->start_date) . "',
                '" . mysqli_real_escape_string($db, $this->visible) . "',
                '" . mysqli_real_escape_string($db, $this->slug) . "',
                '" . mysqli_real_escape_string($db, $this->created_at) . "',
                '" . mysqli_real_escape_string($db, $this->modified_at) . "'
            )
        ");
    }

    public function update($db)
    {
        $db->query("
            UPDATE 
                `stellen` 
            SET 
                `name`               = '" . mysqli_real_escape_string($db, $this->name) . "',
                `beschreibung`       = '" . mysqli_real_escape_string($db, $this->beschreibung) . "',
                `id_stellenart`      = '" . mysqli_real_escape_string($db, $this->id_stellenart) . "',
                `id_ansprechpartner` = '" . mysqli_real_escape_string($db, $this->id_ansprechpartner) . "',
                `id_standort`        = '" . mysqli_real_escape_string($db, $this->id_standort) . "',
                `start_date`         = '" . mysqli_real_escape_string($db, $this->start_date) . "',
                `slug`               = '" . mysqli_real_escape_string($db, $this->slug) . "',
                `modified_at`        = '" . mysqli_real_escape_string($db, $this->modified_at) . "'
            WHERE 
                `id`                 = '" . mysqli_real_escape_string($db, $this->id) . "'
        ");
    }

    public function setHidden($db)
    {
        $db->query("
            UPDATE 
                `stellen` 
            SET 
                `visible`       = '" . 0 . "'
            WHERE 
                `id` = '" . mysqli_real_escape_string($db, $this->id) . "'
        ");
    }

    public function setVisible($db)
    {
        $db->query("
            UPDATE 
                `stellen` 
            SET 
                `visible`       = '" . 1 . "'
            WHERE 
                `id` = '" . mysqli_real_escape_string($db, $this->id) . "'
        ");
    }

    public function slugify($title)
    {
        $slug = '';
        $text = $title;

        // replace non letter or digits by -
        $text = preg_replace('~[^\pL\d]+~u', '-', $text);

        // // transliterate
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

        // // remove unwanted characters
        $text = preg_replace('~[^-\w]+~', '', $text);

        // // trim
        $text = trim($text, '-');

        // // remove duplicate -
        $text = preg_replace('~-+~', '-', $text);

        // // lowercase
        $text = strtolower($text);

        $slug = $text . '-' . time();
        return $slug;
    }

    public function checkAuth($db, $id_stelle)
    {
        $result = $db->query(
            "SELECT 
                id_unternehmen
            FROM
                `stellen`
            WHERE
                `id` = $id_stelle
        "
        );

        $row_cnt = $result->num_rows;
        if ($row_cnt == 0) {
            header('Location: //192.168.0.107/jobembed/intern/noAuth');
        } else {
            $row = $result->fetch_assoc();

            if ($row['id_unternehmen'] != $_SESSION['id_unternehmen']) {
                header('Location: //192.168.0.107/jobembed/intern/noAuth');
            }
        }
    }

    public function stellen_auslesen()
    {
        $this->ausgabe_array = array();
        while ($get_row = mysqli_fetch_assoc($this->ausgabe_query)) {
            $this->ausgabe_array[] = $get_row;
        }
    }
}
