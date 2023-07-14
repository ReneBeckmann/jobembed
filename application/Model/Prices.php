<?php

namespace Model;

class Prices
{
    public $id;
    public $name;
    public $price;
    public $anzJobs;

    public $status;
    public $error;

    public $ausgabe_query;
    public $ausgabe_array;

    public function auslesen()
    {
        $this->ausgabe_array = array();
        while ($get_row = mysqli_fetch_assoc($this->ausgabe_query)) {
            $this->ausgabe_array[] = $get_row;
        }
    }
}
