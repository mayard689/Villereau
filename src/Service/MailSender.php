<?php

namespace App\Service;

use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class MailSender
{
    private $mailer;


    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    public function sendEmail($destination, $html)
    {
        $email = (new Email())
            ->from('doc-albert@laposte.net')
            ->to($destination)
            ->subject('Newsletter de Villereau')
            ->html($html);

        $this->mailer->send($email);
    }
}
