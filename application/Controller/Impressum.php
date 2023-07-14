<?php

namespace Controller;

class Impressum extends \ITSB\Controller
{
    public function IndexAction()
    {
        $this->render('/' . LANG . '/impressum/index.twig', array(), 'default.twig');
    }
}
