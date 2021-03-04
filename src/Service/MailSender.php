<?php

namespace App\Service;

use App\Entity\Content;
use App\Entity\Event;
use App\Entity\NewsletterEmail;
use App\Repository\NewsletterEmailRepository;
use App\Repository\UserRepository;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bridge\Twig\Mime\WrappedTemplatedEmail;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Twig\Environment;

class MailSender
{
    private $mailer;
    private $newsletterEmailRepository;
    private $userRepository;
    private $twig;
    private $params;

    public function __construct(
        MailerInterface $mailer,
        NewsletterEmailRepository $newsletterEmailRepository,
        Environment $twig,
        UserRepository $userRepository,
        ParameterBagInterface $params
    ) {
        $this->mailer = $mailer;
        $this->newsletterEmailRepository = $newsletterEmailRepository;
        $this->twig = $twig;
        $this->userRepository = $userRepository;
        $this->params = $params;
    }

    public function notifyContentToMembers(Content $content)
    {
        $email = (new TemplatedEmail())
            ->from($this->params->get("mailer_from"))
            ->subject('Communication de Villereau');

        $members = $this->newsletterEmailRepository->findAll();

        foreach($members as $member) {
            $email
                ->to($member->getEmail())
                ->htmlTemplate('email/contentNotification.html.twig')
                ->context([
                    'secret' => $member->getSecret(),
                    'content' => $content,
                ]);

            $this->mailer->send($email);
        }
    }

    /**
     * @param Event $event
     * @throws \Symfony\Component\Mailer\Exception\TransportExceptionInterface
     * send notification to people who subscribed to the newsletter
     */
    public function notifyEventToMembers(Event $event)
    {
        $email = (new TemplatedEmail())
            ->from($this->params->get("mailer_from"))
            ->subject('Communication de Villereau');

        $members = $this->newsletterEmailRepository->findAll();

        foreach($members as $member) {
            $email
                ->to($member->getEmail())
                ->htmlTemplate('email/eventNotification.html.twig')
                ->context([
                    'secret' => $member->getSecret(),
                    'event' => $event,
                ]);

            $this->mailer->send($email);
        }
    }

    /**
     * @param Event $event
     * @throws \Symfony\Component\Mailer\Exception\TransportExceptionInterface
     * notify event to people who have a subscriber account
     */
    public function notifyEventToSubscribers(Event $event, $isModified = false)
    {
        $email = (new TemplatedEmail())
            ->from($this->params->get("mailer_from"))
            ->subject('Communication de Villereau');

        $members = $this->userRepository->findBy(array('isVerified' => true));

        foreach($members as $member) {
            $email
                ->to($member->getUsername())
                ->htmlTemplate('email/eventNotification.html.twig')
                ->context([
                    'event' => $event,
                    'isModified' => $isModified
                ]);

            $this->mailer->send($email);
        }
    }
}
