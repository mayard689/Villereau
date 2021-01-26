<?php

namespace App\Controller;

use App\Entity\Partyroom;
use App\Form\PartyroomType;
use App\Repository\PartyroomRepository;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/salle-des-fetes")
 */
class PartyroomController extends AbstractController
{
    /**
     * @Route("/reservation/{year}/{month}", name="partyroom_index", methods={"GET"})
     */
    public function index(PartyroomRepository $partyroomRepository, ?int $year=null, ?int $month=null): Response
    {
        //ifno year is provided assume this year
        if (!$year) {
            $year = date("Y");
        }

        //if no month is provided assume current month
        if (!$month) {
            $month = date("m");
        }

        //build the calendar time
        $time = strtotime("01-".$month."-".$year);

        //get partyroom monthly event
        $startDate = new Datetime("01-".$month."-".$year);
        $endDate = new Datetime("01-".$month."-".$year);
        $endDate->modify('+1 month')->modify('-1 day');
        $events = $partyroomRepository->findEvents($startDate, $endDate);

        //make an array with day number as key and an array of day event as value
        $planning = [];
        foreach ($events as $event) {
            $day = $event->getDate()->format('d');
            $day=ltrim($day, '0');
            $planning[$day][]=$event;
        }

        return $this->render('partyroom/index.html.twig', [
            'partyrooms' => $partyroomRepository->findAll(),
            'time' => $time,
            'currentYear' => $year,
            'currentMonth' => $month,
            'planning' => $planning
        ]);
    }

    /**
     * @Route("/validate/{id}", name="partyroom_validate", methods={"GET","POST"})
     */
    public function validate(Partyroom $partyroom, Request $request): Response
    {
        $partyroom->setValidated(true);
        $this->getDoctrine()->getManager()->flush();
        $this->addFlash('success', 'La date a été validée');

        return $this->redirectToRoute('partyroom_index');
    }

    /**
     * @Route("/reserver/{timestamp}", name="partyroom_new", methods={"GET","POST"})
     */
    public function new(int $timestamp, Request $request): Response
    {
        //if the timestamp is past or if it is more than one year after today
        if ($timestamp < time() || $timestamp > (time() + (365 * 24 * 60 * 60))) {
            return $this->redirectToRoute('partyroom_index');
        }

        $partyroom = new Partyroom();
        $partyroom->setValidated(false);
        $partyroom->setDate(new DateTime('@'.$timestamp));
        $form = $this->createForm(PartyroomType::class, $partyroom);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($partyroom);
            $entityManager->flush();

            return $this->redirectToRoute('partyroom_index');
        }

        return $this->render('partyroom/new.html.twig', [
            'partyroom' => $partyroom,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="partyroom_show", methods={"GET"})
     */
    public function show(Partyroom $partyroom): Response
    {
        return $this->render('partyroom/show.html.twig', [
            'partyroom' => $partyroom,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="partyroom_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Partyroom $partyroom): Response
    {
        $form = $this->createForm(PartyroomType::class, $partyroom);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('partyroom_index');
        }

        return $this->render('partyroom/edit.html.twig', [
            'partyroom' => $partyroom,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="partyroom_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Partyroom $partyroom): Response
    {
        if ($this->isCsrfTokenValid('delete'.$partyroom->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($partyroom);
            $entityManager->flush();
        }

        return $this->redirectToRoute('partyroom_index');
    }
}
