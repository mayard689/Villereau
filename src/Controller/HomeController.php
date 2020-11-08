<?php

namespace App\Controller;

use App\Entity\NewsletterEmail;
use App\Form\NewsletterEmailType;
use App\Repository\ContentRepository;
use App\Repository\EventRepository;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(
        Request $request,
        EventRepository $eventRepository,
        ContentRepository $contentRepository,
        MailerInterface $mailer
    ): Response {

        // Manage newsletter email
        $newsletterEmail = new NewsletterEmail();
        $newsletterForm = $this->createForm(NewsletterEmailType::class, $newsletterEmail);
        $newsletterForm->handleRequest($request);

        if ($newsletterForm->isSubmitted() && $newsletterForm->isValid()) {

            $newsletterEmail->setDate(new DateTime());
            $entityManager = $this->getDoctrine()->getManager();

            $entityManager->persist($newsletterEmail);
            $entityManager->flush();

            $this->addFlash('success', 'Votre inscription à la newsletter a été enregistrée');

            $this->confirmRegistrationToNewsletter($newsletterEmail->getEmail(), $mailer);

            return $this->redirectToRoute('home');
        }

        //manage events
        $events = $eventRepository->findComming(3);

        //manage content (articles)
        $contents= $contentRepository->findComming(4,0);

        return $this->render('home/index.html.twig', [
            'events' => $events,
            'contents' => $contents,
            'newsletterForm' => $newsletterForm->createView(),
        ]);
    }

    private function confirmRegistrationToNewsletter($destination, MailerInterface $mailer)
    {
        $email = (new Email())
            ->from('doc-albert@laposte.net')
            ->to($destination)
            ->subject('Newsletter de Villereau')
            ->html('<p>Bonjour, Nous vous confirmons votre inscription à la newsletter de la mairie de Villereau.</p>');

        $mailer->send($email);
    }
}
