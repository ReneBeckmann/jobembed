<?php

namespace ITSB\Exception;

class FileNotFoundException extends \Exception
{
    private $error;

    public function __construct($message, $code = 0)
    {
        parent::__construct($message, $code);

        $this->message = sprintf("Datei nicht gefunden: %s", $this->message);
    }

    public function errorLog()
    {
        $this->error = ErrorLog::getInstance();
        $this->error->addError($this);
    }
}
