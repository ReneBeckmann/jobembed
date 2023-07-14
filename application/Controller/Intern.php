<?php

namespace Controller;

use \ITSB\Mysql;
use \ITSB\Mailer;
use \Model\User;

use \Model\Stellen          as ModelStellen;
use \Model\Unternehmen      as ModelUnternehmen;
use \Model\Fragen           as ModelFragen;
use \Model\Antworten        as ModelAntworten;
use \Model\Ansprechpartner  as ModelAnsprechpartner;
use \Model\Branchen         as ModelBranchen;
use \Model\Standorte        as ModelStandorte;
use \Model\Prices           as ModelPrices;

class Intern extends \ITSB\Controller
{

    //STELLENANGEBOTE
    public function MeineStellenAction()
    {
        $mysqli = new Mysql();
        $db     = $mysqli->connect();

        $user = new User();
        $user->checkSession($db, $_SESSION['token']);

        $id_unternehmen = $_SESSION['id_unternehmen'];
        $uStatus        = $_SESSION['status'];

        $stellen = new ModelStellen();

        if (isset($_POST['subAddStelle'])) {
            // SLUGIFY
            $slug = $stellen->slugify($_POST['stellenTitle']);

            $stellen->id_unternehmen = $_SESSION['id_unternehmen'];
            $stellen->id_user        = $_SESSION['id_user'];
            $stellen->name           = $_POST['stellenTitle'];
            $stellen->beschreibung   = $_POST['stellenBeschreibung'];
            $stellen->id_stellenart  = $_POST['id_stellenart'];
            $stellen->start_date     = $_POST['start_date'];
            $stellen->visible        = 1;
            $stellen->slug           = $slug;
            $stellen->created_at     = date('Y-m-d H:i:s');
            $stellen->modified_at    = date('Y-m-d H:i:s');

            $stellen->save($db);
        }

        $stellen->ausgabe_query = $db->query(
            "SELECT 
                stellen.*,
                ansprechpartner.vorname as a_vorname,
                ansprechpartner.nachname as a_nachname,
                ansprechpartner.telefon as a_telefon,
                ansprechpartner.email as a_email,
                standorte.strasse as s_strasse,
                standorte.plz as s_plz,
                standorte.ort as s_ort,
                stellenart.name as stellenart
            FROM
                `stellen`
            LEFT JOIN
                `ansprechpartner` ON ansprechpartner.id = stellen.id_ansprechpartner
            LEFT JOIN
                `standorte` ON standorte.id = stellen.id_standort
            LEFT JOIN
                `stellenart` ON stellenart.id = stellen.id_stellenart
            WHERE
                stellen.id_unternehmen = $id_unternehmen
            ORDER BY 
                `visible`
            DESC
        "
        );

        $stellen->stellen_auslesen();

        $query_stellen = $stellen->ausgabe_array;

        $anzJobs = $stellen->ausgabe_query->num_rows;


        $prices = new ModelPrices();
        $prices->ausgabe_query = $db->query(
            "SELECT anzJobs FROM prices WHERE `id` = $uStatus"
        );

        $prices->auslesen();
        $query_prices = $prices->ausgabe_array;

        $this->render('/' . LANG . '/intern/meinestellen.twig', array(
            'stellen'   => $query_stellen,
            'anzJobs'   => $anzJobs,
            'limitJobs' => $query_prices[0]['anzJobs']
        ), 'default.twig');
    }

    public function addJobAction()
    {
        $mysqli = new Mysql();
        $db     = $mysqli->connect();

        $user = new User();
        $user->checkSession($db, $_SESSION['token']);

        $date = date('Y-m-d');
        $id_unternehmen = $_SESSION['id_unternehmen'];


        $ansprechpartner = new ModelAnsprechpartner();
        $ansprechpartner->ausgabe_query = $db->query(
            "SELECT 
                *
            FROM 
                `ansprechpartner`
            WHERE
                `id_unternehmen` = $id_unternehmen
            ORDER BY
                `nachname`
            ASC"
        );
        $ansprechpartner->auslesen();
        $query_ansprechpartner = $ansprechpartner->ausgabe_array;


        $standorte = new ModelStandorte();
        $standorte->ausgabe_query = $db->query(
            "SELECT 
                *
            FROM 
                `standorte`
            WHERE
                `id_unternehmen` = $id_unternehmen
            ORDER BY
                `ort`
            ASC"
        );
        $standorte->auslesen();
        $query_standorte = $standorte->ausgabe_array;


        $this->render('/' . LANG . '/intern/addjob.twig', array(
            'date'              => $date,
            'ansprechpartner'   => $query_ansprechpartner,
            'standorte'         => $query_standorte

        ), 'default.twig');
    }

    public function editJobAction()
    {
        $mysqli = new Mysql();
        $db     = $mysqli->connect();

        $user = new User();
        $user->checkSession($db, $_SESSION['token']);

        $id_unternehmen = $_SESSION['id_unternehmen'];
        $id             = $_GET['id'];

        $stellen = new ModelStellen();
        $stellen->checkAuth($db, $id);

        if (isset($_POST['subEditJob'])) {
            $slug = $stellen->slugify($_POST['stellenTitle']);

            $stellen->id                    = $_POST['jobId'];
            $stellen->name                  = $_POST['stellenTitle'];
            $stellen->beschreibung          = $_POST['stellenBeschreibung'];
            $stellen->id_stellenart         = $_POST['stellenart'];
            $stellen->id_ansprechpartner    = $_POST['ansprechpartner'];
            $stellen->id_standort           = $_POST['standort'];
            $stellen->start_date            = $_POST['start_date'];
            $stellen->slug                  = $slug;
            $stellen->modified_at           = date('Y-m-d H:i:s');

            $stellen->update($db);
        }

        $stellen->ausgabe_query = $db->query("
            SELECT 
                *
            FROM
                `stellen`
            WHERE
                `id` = $id
        ");
        $stellen->stellen_auslesen();
        $query_stellen = $stellen->ausgabe_array;



        $ansprechpartner = new ModelAnsprechpartner();
        $ansprechpartner->ausgabe_query = $db->query(
            "SELECT 
                *
            FROM 
                `ansprechpartner`
            WHERE
                `id_unternehmen` = $id_unternehmen
            ORDER BY
                `nachname`
            ASC"
        );
        $ansprechpartner->auslesen();
        $query_ansprechpartner = $ansprechpartner->ausgabe_array;


        $standorte = new ModelStandorte();
        $standorte->ausgabe_query = $db->query(
            "SELECT 
                *
            FROM 
                `standorte`
            WHERE
                `id_unternehmen` = $id_unternehmen
            ORDER BY
                `ort`
            ASC"
        );
        $standorte->auslesen();
        $query_standorte = $standorte->ausgabe_array;


        $this->render('/' . LANG . '/intern/editJob.twig', array(
            'stellen'         => $query_stellen,
            'ansprechpartner' => $query_ansprechpartner,
            'standorte'       => $query_standorte
        ), 'default.twig');
    }


    //EINSTELLUNGEN
    public function EinstellungenAction()
    {
        $mysqli = new Mysql();
        $db     = $mysqli->connect();

        $user = new User();
        $user->checkSession($db, $_SESSION['token']);

        $id_unternehmen = $_SESSION['id_unternehmen'];

        $unternehmen = new ModelUnternehmen();
        $unternehmen->ausgabe_query = $db->query("
            SELECT 
                *
            FROM
                `unternehmen`
            WHERE
                `id` = $id_unternehmen
        ");
        $unternehmen->unternehmen_auslesen();
        $query_unternehmen = $unternehmen->ausgabe_array;


        $standorte = new ModelStandorte();
        $standorte->ausgabe_query = $db->query("SELECT * FROM `standorte` WHERE `id_unternehmen` = $id_unternehmen ORDER BY `plz` ASC");
        $standorte->auslesen();
        $query_standorte = $standorte->ausgabe_array;

        $this->render('/' . LANG . '/intern/einstellungen.twig', array(
            'unternehmen'       => $query_unternehmen,
            'standorte'         => $query_standorte,
            'primaryColor'      => $query_unternehmen[0]['primaryColor'],
            'bgColor'           => $query_unternehmen[0]['bgColor'],
            'fontColor'         => $query_unternehmen[0]['fontColor'],
            'linkColor'         => $query_unternehmen[0]['linkColor'],
            'pfad'              => $_SERVER['DOCUMENT_ROOT']
        ), 'default.twig');
    }

    //BEWERBUNG
    public function BewerbungAction()
    {
        $mysqli = new Mysql();
        $db     = $mysqli->connect();

        $user = new User();
        $user->checkSession($db, $_SESSION['token']);

        $update = 0;
        $id = $_GET['id'];

        $stellen    = new ModelStellen();
        $fragen     = new ModelFragen();
        $antworten  = new ModelAntworten();


        $stellen->ausgabe_query = $db->query("
            SELECT 
                *
            FROM
                `stellen`
            WHERE
                `id` = $id
        ");
        $stellen->stellen_auslesen();
        $query_stellen = $stellen->ausgabe_array;


        $fragen->ausgabe_query = $db->query("
            SELECT 
                *
            FROM
                `fragen`
            WHERE
                `id_stelle` = $id
            ORDER BY 
                `position` ASC
        ");
        $fragen->fragen_auslesen();
        $query_fragen = $fragen->ausgabe_array;

        $antworten->ausgabe_query = $db->query("
            SELECT 
                *
            FROM
                `antworten`
            WHERE
                `id_stelle` = $id
        ");
        $antworten->antworten_auslesen();
        $query_antworten = $antworten->ausgabe_array;


        if ($fragen->ausgabe_query->num_rows > 0) {
            $update = 1;
        }


        $this->render('/' . LANG . '/intern/bewerbung.twig', array(
            'stellen'   => $query_stellen[0],
            'fragen'    => $query_fragen,
            'antworten' => $query_antworten,
            'isUpdate'  => $update
        ), 'default.twig');
    }


    //MISC
    public function noAuthAction()
    {
        $this->render('/' . LANG . '/intern/noAuth.twig', array(), 'default.twig');
    }


    // AJAX CALLS

    //STAMMDATEN
    public function updateStammdatenAction()
    {
        if (isset($_POST)) {
            $mysqli = new Mysql();
            $db     = $mysqli->connect();

            $user = new User();
            $user->checkSession($db, $_SESSION['token']);

            $unternehmen = new ModelUnternehmen();
            $unternehmen->id            = $_POST['uid'];
            $unternehmen->strasse       = $_POST['strasse'];
            $unternehmen->plz           = $_POST['plz'];
            $unternehmen->ort           = $_POST['ort'];
            $unternehmen->telefon       = $_POST['telefon'];
            $unternehmen->fax           = $_POST['fax'];
            $unternehmen->email         = $_POST['email'];
            $unternehmen->url           = $_POST['url'];
            $unternehmen->urlDisclaimer = $_POST['urlDisclaimer'];
            $unternehmen->update($db);
        }
    }

    public function getUnternehmenInfoAction()
    {
        $mysqli = new Mysql();
        $db     = $mysqli->connect();

        $user = new User();
        $user->checkSession($db, $_SESSION['token']);

        $id_unternehmen = $_SESSION['id_unternehmen'];

        $unternehmen = new ModelUnternehmen();
        $unternehmen->ausgabe_query = $db->query(
            "SELECT 
                * 
            FROM 
                `unternehmen` 
            WHERE 
                `id` = $id_unternehmen
            "
        );
        $unternehmen->unternehmen_auslesen();
        $query_unternehmen = $unternehmen->ausgabe_array;

        $branchen = new ModelBranchen();
        $branchen->ausgabe_query = $db->query("SELECT * FROM `branchen` ORDER BY `name` ASC");
        $branchen->auslesen();
        $query_branchen = $branchen->ausgabe_array;

        $this->render('/' . LANG . '/intern/templates/getUnternehmenInfo.twig', array(
            'unternehmen'   => $query_unternehmen,
            'branchen'      => $query_branchen
        ));
    }

    public function updateUnternehmenInfoAction()
    {
        $mysqli = new Mysql();
        $db     = $mysqli->connect();

        $user = new User();
        $user->checkSession($db, $_SESSION['token']);

        $id_unternehmen = $_SESSION['id_unternehmen'];

        $unternehmen = new ModelUnternehmen();
        $unternehmen->id                = $id_unternehmen;
        $unternehmen->kurzinfo          = $_POST['kurzinfo'];
        $unternehmen->gruendungsjahr    = $_POST['gruendungsjahr'];
        $unternehmen->anzMitarbeiter    = $_POST['anzMitarbeiter'];
        $unternehmen->id_branche        = $_POST['id_branche'];

        $unternehmen->updateUnternehmenInfo($db);
    }

    public function deleteFrageAction()
    {
        if (isset($_POST)) {
            $mysqli = new Mysql();
            $db     = $mysqli->connect();

            $user = new User();
            $user->checkSession($db, $_SESSION['token']);

            //Frage Löschen
            $frage = new ModelFragen();
            $frage->id = $_POST['id'];
            $frage->delete($db);

            // Antworten zur Frage löschen
            $antworten = new ModelAntworten();
            $antworten->id_frage = $_POST['id'];
            $antworten->deleteBulk($db);
        }
    }

    public function deleteAntwortAction()
    {
        if (isset($_POST)) {
            $mysqli = new Mysql();
            $db     = $mysqli->connect();

            $user = new User();
            $user->checkSession($db, $_SESSION['token']);

            $antwort = new ModelAntworten();

            $antwort->id = $_POST['id'];

            $antwort->delete($db);
        }
    }

    public function updateAntwortTextAction()
    {
        if (isset($_POST)) {
            $mysqli = new Mysql();
            $db     = $mysqli->connect();

            $user = new User();
            $user->checkSession($db, $_SESSION['token']);

            $antwort = new ModelAntworten();

            $antwort->id      = $_POST['id'];
            $antwort->antwort = $_POST['antwort'];

            $antwort->update($db);
        }
    }

    public function updateFrageTextAction()
    {
        if (isset($_POST)) {
            $mysqli = new Mysql();
            $db     = $mysqli->connect();

            $user = new User();
            $user->checkSession($db, $_SESSION['token']);

            $frage = new ModelFragen();

            $frage->id     = $_POST['id'];
            $frage->frage  = $_POST['frage'];

            $frage->update($db);
        }
    }

    public function updateFragePositionAction()
    {
        if (isset($_POST)) {
            $mysqli = new Mysql();
            $db     = $mysqli->connect();

            $user = new User();
            $user->checkSession($db, $_SESSION['token']);

            $frage = new ModelFragen();

            $frage->id       = $_POST['id'];
            $frage->position = $_POST['position'];

            $frage->updatePosition($db);
        }
    }

    public function addType1Action()
    {
        if (isset($_POST)) {
            $mysqli = new Mysql();
            $db     = $mysqli->connect();

            $user = new User();
            $user->checkSession($db, $_SESSION['token']);

            $frage          = new ModelFragen();

            $frage->frage = $_POST['frage'];
            $frage->type = $_POST['type'];
            $frage->id_unternehmen = $_POST['id_unternehmen'];
            $frage->id_stelle = $_POST['id_stelle'];
            $frage->position = $_POST['anzahl'];

            $frage->save($db);

            $last_id = $db->insert_id;

            $this->render('/' . LANG . '/intern/templates/addType1.twig', array(
                'anzahl' => $_POST['anzahl'],
                'last_id' => $last_id
            ));
        }
    }

    public function addType2Action()
    {
        if (isset($_POST)) {
            $mysqli = new Mysql();
            $db     = $mysqli->connect();

            $user = new User();
            $user->checkSession($db, $_SESSION['token']);

            $frage          = new ModelFragen();

            $frage->frage = $_POST['frage'];
            $frage->type = $_POST['type'];
            $frage->id_unternehmen = $_POST['id_unternehmen'];
            $frage->id_stelle = $_POST['id_stelle'];
            $frage->position = $_POST['anzahl'];

            $frage->save($db);
            $last_id = $db->insert_id;

            $antwort = new ModelAntworten();

            $antwort->antwort   = '';
            $antwort->id_frage  = $last_id;
            $antwort->id_stelle = $_POST['id_stelle'];

            $antwort->save($db);
            $last_id_antwort = $db->insert_id;

            $this->render('/' . LANG . '/intern/templates/addType2.twig', array(
                'anzahl'            => $_POST['anzahl'],
                'last_id'           => $last_id,
                'last_id_antwort'   => $last_id_antwort
            ));
        }
    }

    public function addAntwortAction()
    {
        if ($_POST) {
            $mysqli = new Mysql();
            $db     = $mysqli->connect();

            $user = new User();
            $user->checkSession($db, $_SESSION['token']);

            $antwort = new ModelAntworten();

            $antwort->antwort   = $_POST['antwort'];
            $antwort->id_frage  = $_POST['id_frage'];
            $antwort->id_stelle = $_POST['id_stelle'];

            $antwort->save($db);

            $last_id_antwort = $db->insert_id;

            $this->render('/' . LANG . '/intern/templates/addAntwort.twig', array(
                'last_id_antwort' => $last_id_antwort
            ));
        }
    }

    public function addType3Action()
    {
        if (isset($_POST)) {
            $mysqli = new Mysql();
            $db     = $mysqli->connect();

            $user = new User();
            $user->checkSession($db, $_SESSION['token']);

            $frage          = new ModelFragen();

            $frage->frage = $_POST['frage'];
            $frage->type = $_POST['type'];
            $frage->id_unternehmen = $_POST['id_unternehmen'];
            $frage->id_stelle = $_POST['id_stelle'];
            $frage->position = $_POST['anzahl'];

            $frage->save($db);
            $last_id = $db->insert_id;

            $antwort = new ModelAntworten();

            $antwort->antwort   = '';
            $antwort->id_frage  = $last_id;
            $antwort->id_stelle = $_POST['id_stelle'];

            $antwort->save($db);
            $last_id_antwort = $db->insert_id;

            $this->render('/' . LANG . '/intern/templates/addType3.twig', array(
                'anzahl'            => $_POST['anzahl'],
                'last_id'           => $last_id,
                'last_id_antwort'   => $last_id_antwort
            ));
        }
    }

    public function addType3AntwortAction()
    {
        $this->render('/' . LANG . '/intern/templates/addType3Antwort.twig', array(
            'parent' => $_POST['parent']
        ));
    }


    // DARSTELLUNG
    public function changeColorAction()
    {
        $mysqli = new Mysql();
        $db     = $mysqli->connect();

        $user = new User();
        $user->checkSession($db, $_SESSION['token']);

        $art   = $_POST['art'];
        $color = $_POST['color'];

        $unternehmen = new ModelUnternehmen();
        $unternehmen->id = $_SESSION['id_unternehmen'];
        $unternehmen->updateColors($db, $art, $color);
    }

    public function updateVorschauAction()
    {
        $mysqli = new Mysql();
        $db     = $mysqli->connect();

        $user = new User();
        $user->checkSession($db, $_SESSION['token']);

        $id_unternehmen = $_SESSION['id_unternehmen'];

        $unternehmen = new ModelUnternehmen();
        $unternehmen->ausgabe_query = $db->query("
            SELECT 
                *
            FROM
                `unternehmen`
            WHERE
                `id` = $id_unternehmen
        ");
        $unternehmen->unternehmen_auslesen();
        $query_unternehmen = $unternehmen->ausgabe_array;

        $stellen = new ModelStellen();
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

        $this->render('/' . LANG . '/intern/templates/einstellungen.vorschau.twig', array(
            'stellen'       => $query_stellen,
            'primaryColor'  => $query_unternehmen[0]['primaryColor'],
            'bgColor'       => $query_unternehmen[0]['bgColor'],
            'fontColor'     => $query_unternehmen[0]['fontColor'],
            'linkColor'     => $query_unternehmen[0]['linkColor']
        ));
    }


    // STELLENVERWALTUNG
    public function setHiddenAction()
    {
        $id = $_POST['id'];

        if (isset($id)) {
            $mysqli = new Mysql();
            $db     = $mysqli->connect();

            $user = new User();
            $user->checkSession($db, $_SESSION['token']);

            $stelle = new ModelStellen();
            // $stelle->modified_at = date('Y-m-d');
            $stelle->id = $id;
            $stelle->setHidden($db);
        }
    }

    public function setVisibleAction()
    {
        $id = $_POST['id'];

        if (isset($id)) {
            $mysqli = new Mysql();
            $db     = $mysqli->connect();

            $user = new User();
            $user->checkSession($db, $_SESSION['token']);

            $stelle = new ModelStellen();
            // $stelle->modified_at = date('Y-m-d');
            $stelle->id = $id;
            $stelle->setVisible($db);
        }
    }


    //EMAIL VERSAND 
    public function sendFormAction()
    {
        $stelle = null;
        $mailtext = null;

        foreach ($_POST as $key => $value) {
            if (substr($key, 0, -3) == 'fragetext') {
                $mailtext .= '<div class="frant">';
            }
            if (!is_array($value)) {

                if ($key == 'datenschutz' || $key == 'bewerberpool' || $key == 'telefon') {
                    $mailtext .= $key . ": ";
                }
                if ($key != 'stelleName') {
                    $mailtext .= $value . '<br>';

                    if (substr($key, 0, -3) == 'antwort') {
                        $mailtext .= '</div>';
                    }
                } else {
                    //STELLENNAME IN VARIABLE SCHREIBEN
                    $stelle = $value;
                }
            } else {
                $mailtext .= "<ul class='ms-5 pt-0'>";
                foreach ($value as $antwort) {
                    $mailtext .= "<li>" . $antwort . "</li>";
                }
                $mailtext .= "</ul>";
                $mailtext .= '</div>';
            }
        }

        $mail = new Mailer;

        // Betreff
        $mail->subject = "Bewerbung";

        // Mail Template
        $mail->template = LANG . '/mailer/default.twig';

        //$mail->toAdress = 're.beckmann@live.de';

        // Mitteilung
        $mail->message = $this->view->render(
            $mail->template,
            array(
                'text'  => $mailtext,
                'stelle' => $stelle
            )
        );

        // Abschicken
        $mail->send();


        //echo $mailtext;
        echo "<pre>";
        print_r($_POST);
        echo "</pre>";
    }


    //ANSPRECHPARTNER
    public function getAnsprechpartnerAction()
    {
        $mysqli = new Mysql();
        $db     = $mysqli->connect();

        $user = new User();
        $user->checkSession($db, $_SESSION['token']);

        $id_unternehmen = $_SESSION['id_unternehmen'];

        $ansprechpartner = new ModelAnsprechpartner();
        $ansprechpartner->ausgabe_query = $db->query("SELECT * FROM `ansprechpartner` WHERE `id_unternehmen` = $id_unternehmen ORDER BY `nachname` ASC");
        $ansprechpartner->auslesen();
        $query_ansprechpartner = $ansprechpartner->ausgabe_array;

        $this->render('/' . LANG . '/intern/templates/getAnsprechpartner.twig', array(
            'ansprechpartner'       => $query_ansprechpartner
        ));
    }

    public function addAnsprechpartnerAction()
    {
        $mysqli = new Mysql();
        $db     = $mysqli->connect();

        $user = new User();
        $user->checkSession($db, $_SESSION['token']);

        $ansprechpartner = new ModelAnsprechpartner();
        $ansprechpartner->vorname           = $_POST['vorname'];
        $ansprechpartner->nachname          = $_POST['nachname'];
        $ansprechpartner->telefon           = $_POST['telefon'];
        $ansprechpartner->email             = $_POST['email'];
        $ansprechpartner->id_unternehmen    = $_SESSION['id_unternehmen'];
        $ansprechpartner->save($db);
    }

    public function deleteAnsprechpartnerAction()
    {
        $mysqli = new Mysql();
        $db     = $mysqli->connect();

        $user = new User();
        $user->checkSession($db, $_SESSION['token']);

        $ansprechpartner = new ModelAnsprechpartner();
        $ansprechpartner->id = $_POST['id'];

        $ansprechpartner->delete($db);
    }


    //STANDORTE
    public function getStandorteAction()
    {
        $mysqli = new Mysql();
        $db     = $mysqli->connect();

        $user = new User();
        $user->checkSession($db, $_SESSION['token']);

        $id_unternehmen = $_SESSION['id_unternehmen'];

        $standorte = new ModelStandorte();
        $standorte->ausgabe_query = $db->query("SELECT * FROM `standorte` WHERE `id_unternehmen` = $id_unternehmen");
        $standorte->auslesen();
        $query_standorte = $standorte->ausgabe_array;

        $this->render('/' . LANG . '/intern/templates/getStandorte.twig', array(
            'standorte'       => $query_standorte
        ));
    }

    public function addStandorteAction()
    {
        $mysqli = new Mysql();
        $db     = $mysqli->connect();

        $user = new User();
        $user->checkSession($db, $_SESSION['token']);

        $standorte = new ModelStandorte();
        $standorte->strasse         = $_POST['strasse'];
        $standorte->plz             = $_POST['plz'];
        $standorte->ort             = $_POST['ort'];
        $standorte->id_unternehmen  = $_SESSION['id_unternehmen'];
        $standorte->save($db);
    }

    public function deleteStandorteAction()
    {
        $mysqli = new Mysql();
        $db     = $mysqli->connect();

        $user = new User();
        $user->checkSession($db, $_SESSION['token']);

        $standorte = new ModelStandorte();
        $standorte->id = $_POST['id'];

        $standorte->delete($db);
    }
}
