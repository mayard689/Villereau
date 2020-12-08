<?php

namespace App\Controller;

use App\Entity\NewspaperSubject2;
use App\Form\NewspaperSubject2Type;
use App\Repository\NewspaperSubject2Repository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/newspaper/subject2")
 */
class NewspaperSubject2Controller extends AbstractController
{
    /**
     * @Route("/", name="newspaper_subject2_index", methods={"GET"})
     */
    public function index(NewspaperSubject2Repository $newspaperSubject2Repository): Response
    {
        return $this->render('newspaper_subject2/index.html.twig', [
            'newspaper_subject2s' => $newspaperSubject2Repository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="newspaper_subject2_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $newspaperSubject2 = new NewspaperSubject2();
        $form = $this->createForm(NewspaperSubject2Type::class, $newspaperSubject2);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($newspaperSubject2);
            $entityManager->flush();

            return $this->redirectToRoute('newspaper_subject2_index');
        }

        return $this->render('newspaper_subject2/new.html.twig', [
            'newspaper_subject2' => $newspaperSubject2,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="newspaper_subject2_show", methods={"GET"})
     */
    public function show(NewspaperSubject2 $newspaperSubject2): Response
    {
        return $this->render('newspaper_subject2/show.html.twig', [
            'newspaper_subject2' => $newspaperSubject2,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="newspaper_subject2_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, NewspaperSubject2 $newspaperSubject2): Response
    {
        $form = $this->createForm(NewspaperSubject2Type::class, $newspaperSubject2);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('newspaper_subject2_index');
        }

        return $this->render('newspaper_subject2/edit.html.twig', [
            'newspaper_subject2' => $newspaperSubject2,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="newspaper_subject2_delete", methods={"DELETE"})
     */
    public function delete(Request $request, NewspaperSubject2 $newspaperSubject2): Response
    {
        if ($this->isCsrfTokenValid('delete'.$newspaperSubject2->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($newspaperSubject2);
            $entityManager->flush();
        }

        return $this->redirectToRoute('newspaper2_edit',['id'=>$newspaperSubject2->getNewspaper2()->getId()]);
    }
}
