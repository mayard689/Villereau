<?php

namespace App\Controller;

use App\Entity\Partyroom;
use App\Form\PartyroomType;
use App\Repository\PartyroomRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/partyroom")
 */
class PartyroomController extends AbstractController
{
    /**
     * @Route("/", name="partyroom_index", methods={"GET"})
     */
    public function index(PartyroomRepository $partyroomRepository): Response
    {
        return $this->render('partyroom/index.html.twig', [
            'partyrooms' => $partyroomRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="partyroom_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $partyroom = new Partyroom();
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
