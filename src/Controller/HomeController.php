<?php

namespace App\Controller;

use App\Repository\EventRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/home", name="home")
     */
    public function index(EventRepository $eventRepository): Response
    {
        $events = $eventRepository->findComming(3);

        return $this->render('home/index.html.twig', [
            'events' => $events,
        ]);
    }
}
