<?php

namespace Controller;

use \ITSB\Mysql;
use \Model\User;

use \Model\Stellen as ModelStellen;

class Stellenangebote extends \ITSB\Controller
{
    public function IndexAction()
    {
        $mysqli = new Mysql();
        $db     = $mysqli->connect();

        $stellen = new ModelStellen();


        if (isset($_GET['id'])) {
            $slug = $_GET['id'];

            $stellen->ausgabe_query = $db->query("
                SELECT 
                    stellen.name,
                    stellen.beschreibung,
                    stellen.slug,
                    unternehmen.name as unternehmensname,
                    unternehmen.strasse,
                    unternehmen.plz,
                    unternehmen.ort,
                    unternehmen.telefon,
                    unternehmen.fax,
                    unternehmen.email,
                    unternehmen.url
                FROM 
                    `stellen`
                LEFT JOIN `unternehmen` ON unternehmen.id = stellen.id_unternehmen
                WHERE 
                    stellen.slug = '$slug'
            ");

            $stellen->stellen_auslesen();

            $query_stellen = $stellen->ausgabe_array;

            $this->render('/' . LANG . '/stellen/details.twig', array(
                'stellen'  => $query_stellen
            ), 'default.twig');
        } else {
            $stellen->ausgabe_query = $db->query("
                SELECT 
                    stellen.name,
                    stellen.beschreibung,
                    stellen.slug,
                    unternehmen.name as unternehmensname,
                    unternehmen.strasse,
                    unternehmen.plz,
                    unternehmen.ort,
                    unternehmen.telefon,
                    unternehmen.fax,
                    unternehmen.email,
                    unternehmen.url
                FROM 
                    `stellen`
                LEFT JOIN `unternehmen` ON unternehmen.id = stellen.id_unternehmen
            ");

            $stellen->stellen_auslesen();

            $query_stellen = $stellen->ausgabe_array;

            $this->render('/' . LANG . '/stellen/index.twig', array(
                'stellen'  => $query_stellen
            ), 'default.twig');
        }
    }

    public function DetailsAction()
    {
        $mysqli = new Mysql();
        $db     = $mysqli->connect();

        $slug = $_GET['id'];

        $stellen = new ModelStellen();
        $stellen->ausgabe_query = $db->query("
            SELECT 
                stellen.name,
                stellen.beschreibung,
                stellen.slug,
                unternehmen.name as unternehmensname,
                unternehmen.strasse,
                unternehmen.plz,
                unternehmen.ort,
                unternehmen.telefon,
                unternehmen.fax,
                unternehmen.email,
                unternehmen.url
            FROM 
                stellen
            LEFT JOIN `unternehmen` ON unternehmen.id = stellen.id_unternehmen
            WHERE
                stellen.slug = '$slug'
        ");

        $stellen->stellen_auslesen();

        $query_stellen = $stellen->ausgabe_array;

        $this->render('/' . LANG . '/stellen/details.twig', array(
            'stellen'  => $query_stellen
        ), 'default.twig');
    }

    public function MeineStellenAction()
    {
        $mysqli = new Mysql();
        $db     = $mysqli->connect();

        $user = new User();
        $user->checkSession();

        $id_unternehmen = $_SESSION['id_unternehmen'];

        $stellen = new ModelStellen();

        if ($_POST['subAddStelle']) {
            // SLUGIFY
            $slug = $stellen->slugify($_POST['stellenTitle'], $_SESSION['id_unternehmen']);
            $stellen->id_unternehmen = $_SESSION['id_unternehmen'];
            $stellen->id_user        = $_SESSION['id_user'];
            $stellen->name           = $_POST['stellenTitle'];
            $stellen->beschreibung   = $_POST['stellenBeschreibung'];
            $stellen->visible        = 1;
            $stellen->slug           = $slug;
            $stellen->created_at     = date('Y-m-d');
            $stellen->modified_at    = date('Y-m-d');

            $stellen->save($db);
        }

        $stellen->ausgabe_query = $db->query("
            SELECT 
                *
            FROM
                `stellen`
            WHERE
                `id_unternehmen` = $id_unternehmen
        ");
        $stellen->stellen_auslesen();

        $query_stellen = $stellen->ausgabe_array;

        $this->render('/' . LANG . '/stellen/meinestellen.twig', array(
            'stellen'  => $query_stellen
        ), 'default.twig');
    }

    public function addAction()
    {
        $user = new User();
        $user->checkSession();

        $this->render('/' . LANG . '/stellen/add.twig', array(), 'default.twig');
    }
}
