<?php

namespace Controller;

class Index extends \ITSB\Controller
{
    public function IndexAction()
    {
        $this->render('/' . LANG . '/index/index.twig', array(), 'default.twig');
    }
}
