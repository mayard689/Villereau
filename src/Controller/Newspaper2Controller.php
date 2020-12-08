<?php

namespace App\Controller;

use App\Entity\Newspaper2;
use App\Entity\NewspaperSubject2;
use App\Form\Newspaper2Type;
use App\Form\NewspaperSubject2Type;
use App\Repository\Newspaper2Repository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/newspaper2")
 */
class Newspaper2Controller extends AbstractController
{
    /**
     * @Route("/", name="newspaper2_index", methods={"GET"})
     */
    public function index(Newspaper2Repository $newspaper2Repository): Response
    {
        return $this->render('newspaper2/index.html.twig', [
            'newspapers' => $newspaper2Repository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="newspaper2_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $newspaper2 = new Newspaper2();
        $newspaper2->setDate(new \DateTime('now'));
        $form = $this->createForm(Newspaper2Type::class, $newspaper2);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($newspaper2);
            $entityManager->flush();

            return $this->redirectToRoute('newspaper2_edit',['id'=>$newspaper2->getId()]);
        }

        return $this->render('newspaper2/new.html.twig', [
            'newspaper2' => $newspaper2,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="newspaper2_show", methods={"GET"})
     */
    public function show(Newspaper2 $newspaper2): Response
    {
        return $this->render('newspaper2/show.html.twig', [
            'newspaper2' => $newspaper2,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="newspaper2_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Newspaper2 $newspaper2): Response
    {
        //manage new newspaper form
        $form = $this->createForm(Newspaper2Type::class, $newspaper2);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('newspaper2_index');
        }

        // Manage new subject form
        $newspaperSubject2 = new NewspaperSubject2();
        $formSubject = $this->createForm(NewspaperSubject2Type::class, $newspaperSubject2);
        $formSubject->handleRequest($request);

        if ($formSubject->isSubmitted() && $formSubject->isValid()  && $formSubject->getData()->getId() == null) {
            $entityManager = $this->getDoctrine()->getManager();
            $newspaperSubject2->setNewspaper2($newspaper2);
            $entityManager->persist($newspaperSubject2);
            $entityManager->flush();

            return $this->redirectToRoute('newspaper2_edit',['id'=>$newspaper2->getId()]);
        }

        return $this->render('newspaper2/edit.html.twig', [
            'newspaper2' => $newspaper2,
            'form' => $form->createView(),
            'formSubject' => $formSubject->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="newspaper2_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Newspaper2 $newspaper2): Response
    {
        if ($this->isCsrfTokenValid('delete'.$newspaper2->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($newspaper2);
            $entityManager->flush();
        }

        return $this->redirectToRoute('newspaper2_index');
    }
}
