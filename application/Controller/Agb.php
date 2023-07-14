<?php

namespace Controller;

class Agb extends \ITSB\Controller
{
    public function IndexAction()
    {
        $this->render('/' . LANG . '/agb/index.twig', array(), 'default.twig');
    }
}
