<?php

namespace App\Controller;

use App\Entity\Newspaper;
use App\Entity\NewspaperSubject;
use App\Form\NewspaperSubjectType;
use App\Repository\NewspaperSubjectRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/newspaper/subject")
 */
class NewspaperSubjectController extends AbstractController
{
    /**
     * @Route("/", name="newspaper_subject_index", methods={"GET"})
     */
    public function index(NewspaperSubjectRepository $newspaperSubjectRepository): Response
    {
        return $this->render('newspaper_subject/index.html.twig', [
            'newspaper_subjects' => $newspaperSubjectRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="newspaper_subject_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $newspaperSubject = new NewspaperSubject();
        $form = $this->createForm(NewspaperSubjectType::class, $newspaperSubject);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($newspaperSubject);
            $entityManager->flush();

            return $this->redirectToRoute('newspaper_subject_index');
        }

        return $this->render(',newspaper_subject/new.html.twig', [
            'newspaper_subject' => $newspaperSubject,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="newspaper_subject_show", methods={"GET"})
     */
    public function show(NewspaperSubject $newspaperSubject): Response
    {
        return $this->render('newspaper_subject/show.html.twig', [
            'newspaper_subject' => $newspaperSubject,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="newspaper_subject_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, NewspaperSubject $newspaperSubject): Response
    {
        $form = $this->createForm(NewspaperSubjectType::class, $newspaperSubject);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('newspaper_subject_index');
        }

        return $this->render('newspaper_subject/edit.html.twig', [
            'newspaper_subject' => $newspaperSubject,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="newspaper_subject_delete", methods={"DELETE"})
     */
    public function delete(Request $request, NewspaperSubject $newspaperSubject): Response
    {
        if ($this->isCsrfTokenValid('delete'.$newspaperSubject->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($newspaperSubject);
            $entityManager->flush();
        }

        return $this->redirectToRoute('newspaper_edit',['id'=>$newspaperSubject->getNewspaper()->getId()]);
    }
}
