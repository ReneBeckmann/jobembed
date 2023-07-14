<?php

namespace ITSB;

require_once(dirname(__FILE__) . '/../Phpmailer/class.phpmailer.php');

class Mailer
{

    public $mail;

    public $subject;

    public $message;

    public $from;

    public $fromAddress;

    public $toAddress;

    public $template;

    public function __construct()
    {
        $this->mail = new \PHPMailer();

        $settings = Helper::requireOnce(getcwd() . '/config/mailer.php');

        $this->from  = $settings['from'];
        $this->fromAddress = $settings['fromAddress'];
        $this->toAddress = $settings['toAddress'];

        $this->mail->CharSet = $settings['charset'];

        $this->template = $settings['template'];

        if ($settings['smtp']['activate'] === TRUE) {
            $this->mail->IsSMTP();
            $this->mail->SMTPAuth = $settings['smtp']['auth'];
            $this->mail->Host = $settings['smtp']['host'];
            $this->mail->Username = $settings['smtp']['user'];
            $this->mail->Password = $settings['smtp']['password'];
        }

        if ($settings['html'] === TRUE) {
            $this->mail->IsHTML(TRUE);
        }
    }

    public function attachment($src, $name)
    {
        $this->mail->AddAttachment($src, $name);
    }

    public function send()
    {
        // Absender
        $this->mail->SetFrom($this->fromAddress, $this->from);

        // Subject
        $this->mail->Subject  = $this->subject;

        // Body
        $this->mail->Body = $this->message;

        $this->mail->ClearAddresses();
        $this->mail->AddAddress($this->toAddress);
        $this->mail->Send();
    }
}
