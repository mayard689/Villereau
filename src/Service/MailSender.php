<?php

namespace App\Service;

use App\Entity\Content;
use App\Entity\Event;
use App\Entity\NewsletterEmail;
use App\Repository\NewsletterEmailRepository;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bridge\Twig\Mime\WrappedTemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Twig\Environment;

class MailSender
{
    private $mailer;
    private $newsletterEmailRepository;
    private $twig;

    public function __construct(MailerInterface $mailer, NewsletterEmailRepository $newsletterEmailRepository, Environment $twig)
    {
        $this->mailer = $mailer;
        $this->newsletterEmailRepository = $newsletterEmailRepository;
        $this->twig = $twig;
    }

    public function notifyContentToMembers(Content $content)
    {
        $email = (new TemplatedEmail())
            ->from($this->getParameter("mailer_from"))
            ->subject('Communication de Villereau');

        $members = $this->newsletterEmailRepository->findAll();

        foreach($members as $member) {
            $email
                ->to($member->getEmail())
                ->htmlTemplate('email/contentNotification.html.twig')
                ->context([
                    'destination' => $member,
                    'content' => $content,
                ]);

            $this->mailer->send($email);
        }
    }

    public function notifyEventToMembers(Event $event)
    {
        $email = (new TemplatedEmail())
            ->from($this->getParameter("mailer_from"))
            ->subject('Communication de Villereau');

        $members = $this->newsletterEmailRepository->findAll();

        foreach($members as $member) {
            $email
                ->to($member->getEmail())
                ->htmlTemplate('email/eventNotification.html.twig')
                ->context([
                    'destination' => $member,
                    'event' => $event,
                ]);

            $this->mailer->send($email);
        }
    }
}
