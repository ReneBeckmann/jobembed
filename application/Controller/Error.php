<?php

namespace Controller;

class Error extends \ITSB\Controller
{
    public function IndexAction()
    {
        $site_config = Helper::requireOnce(dirname(__FILE__) . '/../config/site.php');

        $errorLog = ErrorLog::getInstance();

        if (Helper::getValue($site_config['show_error'])) {

            $this->render('/error/development.twig', array(
                'errors' => $errorLog->exceptions,
            ));
        } else {

            $this->render('/error/production.twig', array(
                'errors' => $errorLog->exceptions,
            ));
        }
    }

    public function SiteNotFoundAction()
    {
        $this->render('/error/404.twig');
    }
}
