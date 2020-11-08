<?php

namespace App\Controller;

use App\Repository\ContentRepository;
use App\Repository\EventRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(EventRepository $eventRepository, ContentRepository $contentRepository): Response
    {
        $events = $eventRepository->findComming(3);
        $contents= $contentRepository->findComming(4,0);

        return $this->render('home/index.html.twig', [
            'events' => $events,
            'contents' => $contents,
        ]);
    }
}
