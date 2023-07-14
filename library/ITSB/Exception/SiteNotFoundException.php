<?php

namespace ITSB\Exception;

class SiteNotFoundException extends \Exception
{
    private $error;

    public function __construct($message, $code = 0)
    {
        parent::__construct($message, $code);

        $this->message = sprintf("Seite nicht gefunden: %s", $this->message);
    }

    public function errorLog()
    {
        $this->error = ErrorLog::getInstance();
        $this->error->addError($this);
    }
}
