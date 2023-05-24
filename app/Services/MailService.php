<?php

namespace App\Services;

use App\Mail\MailReceived;
use Illuminate\Support\Facades\Mail;

class MailService
{
    private $email = '';

    private $cc = [];

    private $view = '';

    private $subject = '';

    private $files = [];

    public function setEmailTo($email)
    {
        $this->email = $email;
    }

    public function setCc($cc)
    {
        $this->cc = $cc;
    }

    public function setView($view)
    {
        $this->view = $view;
    }

    public function setSubject($subject)
    {
        $this->subject = $subject;
    }

    public function setFile($files)
    {
        $this->files = $files;
    }

    public function sendMessage($data = [])
    {

        Mail::to($this->email)->cc($this->cc)->send(new MailReceived($this->view, $this->subject, $data, $this->files));

    }
}
