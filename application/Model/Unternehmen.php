<?php

namespace Model;

class unternehmen
{
    public $id;
    public $name;
    public $strasse;
    public $plz;
    public $ort;
    public $telefon;
    public $fax;
    public $email;
    public $url;
    public $urlDisclaimer;
    public $kurzinfo;
    public $gruendungsjahr;
    public $anzMitarbeiter;
    public $id_branche;
    public $bgColor;
    public $primaryColor;
    public $secondaryColor;
    public $fontColor;
    public $linkColor;
    public $apikey;
    public $status;
    public $verified;

    public $ausgabe_query;
    public $ausgabe_array;

    public function save($db)
    {
        if ($db->query("
            INSERT INTO `unternehmen` (
                `name`,
                `strasse`,
                `plz`,
                `ort`,
                `telefon`,
                `fax`,
                `email`,
                `url`,
                `apikey`,
                `status`,
                `verified`
            ) 
            VALUES (
                '" . mysqli_real_escape_string($db, $this->name) . "',
                '" . mysqli_real_escape_string($db, $this->strasse) . "',
                '" . mysqli_real_escape_string($db, $this->plz) . "',
                '" . mysqli_real_escape_string($db, $this->ort) . "',
                '" . mysqli_real_escape_string($db, $this->telefon) . "',
                '" . mysqli_real_escape_string($db, $this->fax) . "',
                '" . mysqli_real_escape_string($db, $this->email) . "',
                '" . mysqli_real_escape_string($db, $this->url) . "',
                '" . mysqli_real_escape_string($db, $this->apikey) . "',
                '" . mysqli_real_escape_string($db, $this->status) . "',
                '" . mysqli_real_escape_string($db, $this->verified) . "'
            )
        ")) {
            return true;
        }
    }

    public function update($db)
    {
        $db->query("
            UPDATE 
                `unternehmen` 
            SET 
                `strasse`       = '" . mysqli_real_escape_string($db, $this->strasse) . "',
                `plz`           = '" . mysqli_real_escape_string($db, $this->plz) . "',
                `ort`           = '" . mysqli_real_escape_string($db, $this->ort) . "',
                `telefon`       = '" . mysqli_real_escape_string($db, $this->telefon) . "',
                `fax`           = '" . mysqli_real_escape_string($db, $this->fax) . "',
                `email`         = '" . mysqli_real_escape_string($db, $this->email) . "',
                `url`           = '" . mysqli_real_escape_string($db, $this->url) . "',
                `urlDisclaimer` = '" . mysqli_real_escape_string($db, $this->urlDisclaimer) . "'
            WHERE 
                `id` = '" . mysqli_real_escape_string($db, $this->id) . "'
        ");
    }

    public function updateUnternehmenInfo($db)
    {
        $db->query("
            UPDATE 
                `unternehmen` 
            SET 
                `kurzinfo`       = '" . mysqli_real_escape_string($db, $this->kurzinfo) . "',
                `gruendungsjahr` = '" . mysqli_real_escape_string($db, $this->gruendungsjahr) . "',
                `anzMitarbeiter` = '" . mysqli_real_escape_string($db, $this->anzMitarbeiter) . "',
                `id_branche`     = '" . mysqli_real_escape_string($db, $this->id_branche) . "'
            WHERE 
                `id` = '" . mysqli_real_escape_string($db, $this->id) . "'
        ");
    }

    public function verifyAccount($db)
    {
        $db->query("UPDATE `unternehmen` SET `verified`= 1 WHERE `email` = '" . mysqli_real_escape_string($db, $this->email) . "'");
    }

    public function apiKeyGenerator($prefix)
    {
        // // replace non letter or digits by -
        $prefix = preg_replace('~[^\pL\d]+~u', '-', $prefix);
        // // transliterate
        $prefix = iconv('utf-8', 'us-ascii//TRANSLIT', $prefix);
        // // remove unwanted characters
        $prefix = preg_replace('~[^-\w]+~', '', $prefix);
        // // trim
        $prefix = trim($prefix, '-');
        // // remove duplicate -
        $prefix = preg_replace('~-+~', '-', $prefix);
        // // lowercase
        $prefix = strtolower($prefix);
        $uid = uniqid($prefix, true);
        return $uid;
    }

    public function updateColors($db, $art, $color)
    {
        $db->query("
            UPDATE 
                `unternehmen` 
            SET 
                `" . $art . "`      = '" . $color . "'
            WHERE 
                `id` = '" . mysqli_real_escape_string($db, $this->id) . "'
        ");
    }

    public function unternehmen_auslesen()
    {
        $this->ausgabe_array = array();
        while ($get_row = mysqli_fetch_assoc($this->ausgabe_query)) {
            $this->ausgabe_array[] = $get_row;
        }
    }
}
