<?php

class Beispiel extends Controller
{
    public function IndexAction()
    {
        $mailer = new Mailer;

        // Betreff
        $mailer->subject = "Test";

        // Mitteilung
        $mailer->message = $this->view->render(
            $mailer->template,
            array( 'message' => 'Es funktioniert!')
        );

        // Abschicken
        $mailer->send();

        /**
         * OPTIONAL
         * In der config/mailer.php können bereits Absender und Empfänger angegeben werden.
         * Diese können aber auch im Controller überschrieben werden, ebenso andere Einstellungen.
         *
         * Absender Name:   $mailer->from
         * Absender Email:  $mailer->fromAddress
         *
         * Empfänger Email: $mailer->toAddress
         *
         * Template:        $mailer->template
         */


        $this->render('/index/index.twig', array(

        ));
    }
}