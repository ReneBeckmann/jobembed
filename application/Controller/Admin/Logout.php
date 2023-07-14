<?php

namespace Controller\Admin;

use \ITSB\Controller;
use \Model\User;

class Logout extends Controller
{
    public function IndexAction()
    {
        $logout = new User();
        $logout->logout();
    }
}
