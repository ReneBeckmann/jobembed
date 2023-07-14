<?php

namespace Controller;

class Datenschutz extends \ITSB\Controller
{
    public function IndexAction()
    {
        $this->render('/' . LANG . '/datenschutz/index.twig', array(), 'default.twig');
    }
}
