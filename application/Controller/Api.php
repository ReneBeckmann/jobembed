<?php

namespace Controller;

use \ITSB\Mysql;

use \Model\Stellen      as ModelStellen;
use \Model\Fragen       as ModelFragen;
use \Model\Antworten    as ModelAntworten;

class Api extends \ITSB\Controller
{
    public function VAction()
    {
        if (isset($_POST['id'])) {
            $key = $_POST['id'];
        }

        $mysqli     = new Mysql();
        $db         = $mysqli->connect();

        $stellen = new ModelStellen();

        $stellen->ausgabe_query = $db->query("SELECT * FROM `unternehmen` WHERE `apikey` = '$key' AND `verified` = 1");
        $stellen->stellen_auslesen();
        $stellen = $stellen->ausgabe_array;

        if (count($stellen) != 1) return;
        echo $response = json_encode($stellen);
    }

    public function TemplateAction()
    {
        $key = $_GET['id'];

        $mysqli     = new Mysql();
        $db         = $mysqli->connect();

        $stellen = new ModelStellen();

        $stellen->ausgabe_query = $db->query(
            "SELECT 
                stellen.id, 
                stellen.name, 
                stellen.beschreibung, 
                stellen.visible, 
                ansprechpartner.vorname as a_vorname,
                ansprechpartner.nachname as a_nachname,
                ansprechpartner.telefon as a_telefon,
                ansprechpartner.email as a_email,
                standorte.strasse as s_strasse,
                standorte.plz as s_plz,
                standorte.ort as s_ort,
                stellenart.name as st_name,
                unternehmen.bgColor, 
                unternehmen.primaryColor, 
                unternehmen.secondaryColor, 
                unternehmen.fontColor, 
                unternehmen.linkColor 
            FROM 
                unternehmen 
            LEFT JOIN 
                `stellen` ON unternehmen.id = stellen.id_unternehmen 
            LEFT JOIN 
                `stellenart` ON stellen.id_stellenart = stellenart.id
            LEFT JOIN
                `ansprechpartner` ON stellen.id_ansprechpartner = ansprechpartner.id
            LEFT JOIN
                `standorte` ON stellen.id_standort = standorte.id
            WHERE 
                unternehmen.apikey = '$key' AND stellen.visible = 1"
        );
        $stellen->stellen_auslesen();
        $query_stellen = $stellen->ausgabe_array;

        $this->render('/' . LANG . '/template/index.twig', array(
            'stellen'           => $query_stellen,
            'bgColor'           => $query_stellen[0]['bgColor'],
            'primaryColor'      => $query_stellen[0]['primaryColor'],
            'secondaryColor'    => $query_stellen[0]['secondaryColor'],
            'fontColor'         => $query_stellen[0]['fontColor'],
            'linkColor'         => $query_stellen[0]['linkColor']
        ), 'templateLayout.twig');
    }

    public function BewerbungAction()
    {

        $id = $_GET['id'];

        $mysqli     = new Mysql();
        $db         = $mysqli->connect();

        $stellen    = new ModelStellen();
        $fragen     = new ModelFragen();
        $antworten  = new ModelAntworten();


        $stellen->ausgabe_query = $db->query(
            "SELECT 
                stellen.id, 
                stellen.name, 
                stellen.beschreibung,
                unternehmen.name as unternehmensname,
                unternehmen.urlDisclaimer,
                unternehmen.bgColor, 
                unternehmen.primaryColor, 
                unternehmen.secondaryColor, 
                unternehmen.fontColor, 
                unternehmen.linkColor,
                unternehmen.apikey
            FROM 
                unternehmen 
            LEFT JOIN 
                stellen ON unternehmen.id = stellen.id_unternehmen 
            WHERE 
                stellen.id = $id
            "
        );
        $stellen->stellen_auslesen();
        $query_stellen = $stellen->ausgabe_array;

        $fragen->ausgabe_query = $db->query(
            "SELECT
                *
            FROM
                fragen
            WHERE
                id_stelle = $id
            ORDER BY
                position ASC
            "
        );
        $fragen->fragen_auslesen();
        $query_fragen = $fragen->ausgabe_array;


        $antworten->ausgabe_query = $db->query(
            "SELECT
                *
            FROM
                antworten
            WHERE
                id_stelle = $id
            "
        );
        $antworten->antworten_auslesen();
        $query_antworten = $antworten->ausgabe_array;

        $this->render('/' . LANG . '/template/bewerbung.twig', array(
            'stelle'            => $query_stellen[0],
            'unternehmen'       => $query_stellen[0]['unternehmensname'],
            'urlDisclaimer'     => $query_stellen[0]['urlDisclaimer'],
            'bgColor'           => $query_stellen[0]['bgColor'],
            'primaryColor'      => $query_stellen[0]['primaryColor'],
            'secondaryColor'    => $query_stellen[0]['secondaryColor'],
            'fontColor'         => $query_stellen[0]['fontColor'],
            'linkColor'         => $query_stellen[0]['linkColor'],
            'fragen'            => $query_fragen,
            'antworten'         => $query_antworten
        ), 'templateLayout.twig');
    }
}
