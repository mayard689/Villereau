<?php

namespace App\Controller;

use App\Entity\Event;
use App\Form\EventType;
use App\Repository\EventRepository;
use App\Service\MailSender;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/event")
 */
class EventController extends AbstractController
{
    /**
     * @Route("/", name="event_index", methods={"GET"})
     */
    public function index(EventRepository $eventRepository): Response
    {
        //chek if user can see restricted events
        $criteria = array();
        if (!$this->isGranted('ROLE_SUBSCRIBER')) {
            $criteria = array("restricted" => 0);
        }

        return $this->render('event/index.html.twig', [
            'events' => $eventRepository->findBy($criteria, array('date' => 'DESC')),
        ]);
    }

    /**
     * @Route("/new", name="event_new", methods={"GET","POST"})
     */
    public function new(Request $request, MailSender $mailSender): Response
    {
        $event = new Event();
        $form = $this->createForm(EventType::class, $event);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($event);
            $entityManager->flush();

            //notify people who have a registered and verified account
            try {
                $mailSender->notifyEventToSubscribers($event, false);
                $this->addFlash('success', 'Votre évènement a bien été créé. Le conseil a été informé par email.');
            } catch (TransportExceptionInterface $e) {
                $this->addFlash('danger', 'Votre évènement a bien été créé. Un probleme est survenu pendant l\'envoie des emails au conseil.');
            }

            return $this->redirectToRoute('event_index');
        }

        return $this->render('event/new.html.twig', [
            'event' => $event,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="event_show", methods={"GET"})
     */
    public function show(Event $event): Response
    {
        return $this->render('event/show.html.twig', [
            'event' => $event,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="event_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Event $event, MailSender $mailSender): Response
    {
        $form = $this->createForm(EventType::class, $event);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            //notify people who have a registered and verified account
            try {
                $mailSender->notifyEventToSubscribers($event, true);
                $this->addFlash('success', 'Votre évènement a bien été modifié. Le conseil a été informé par email.');
            } catch (TransportExceptionInterface $e) {
                $this->addFlash('danger', 'Votre évènement a bien été modifié. Un probleme est survenu pendant l\'envoie des emails au conseil.');
            }

            return $this->redirectToRoute('event_index');
        }

        return $this->render('event/edit.html.twig', [
            'event' => $event,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="event_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Event $event): Response
    {
        if ($this->isCsrfTokenValid('delete'.$event->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($event);
            $entityManager->flush();
        }

        return $this->redirectToRoute('event_index');
    }

    /**
     * @Route("/{id}/notify", name="event_notify", methods={"GET","POST"})
     */
    public function notify(Event $event, MailSender $mailSender): Response
    {

        //notify people who subscribed to the newsletter
        try {
            $mailSender->notifyEventToMembers($event);
            $this->addFlash('success', 'Un email a bien été envoyé à tous les abonnés concernant l\'évènement .'.$event->getName());
        } catch (TransportExceptionInterface $e) {
            $this->addFlash('danger', 'Un problème est survenu pendant l\'envoie des emails');
        }

        return $this->redirectToRoute('event_index');
    }
}
