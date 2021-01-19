<?php

namespace App\Controller;

use App\Entity\Teammate;
use App\Form\TeammateType;
use App\Repository\TeammateRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/teammate")
 */
class TeammateController extends AbstractController
{
    /**
     * @Route("/", name="teammate_index", methods={"GET"})
     */
    public function index(TeammateRepository $teammateRepository): Response
    {
        return $this->render('teammate/index.html.twig', [
            'teammates' => $teammateRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="teammate_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $teammate = new Teammate();
        $form = $this->createForm(TeammateType::class, $teammate);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($teammate);
            $entityManager->flush();

            return $this->redirectToRoute('teammate_index');
        }

        return $this->render('teammate/new.html.twig', [
            'teammate' => $teammate,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="teammate_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Teammate $teammate): Response
    {
        $form = $this->createForm(TeammateType::class, $teammate);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('teammate_index');
        }

        return $this->render('teammate/edit.html.twig', [
            'teammate' => $teammate,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="teammate_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Teammate $teammate): Response
    {
        if ($this->isCsrfTokenValid('delete'.$teammate->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($teammate);
            $entityManager->flush();
        }

        return $this->redirectToRoute('teammate_index');
    }
}
