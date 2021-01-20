<?php

namespace App\Controller;

use App\Entity\Newspaper;
use App\Entity\NewspaperSubject;
use App\Form\NewspaperSubjectType;
use App\Form\NewspaperType;
use App\Repository\Newspaper2Repository;
use App\Repository\NewspaperRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/newspaper")
 */
class NewspaperController extends AbstractController
{
    /**
     * @Route("/", name="newspaper_index", methods={"GET"})
     */
    public function index(NewspaperRepository $newspaperRepository, Newspaper2Repository $newspaper2Repository): Response
    {
        $newspapers = $newspaperRepository->findBy(array(), array('date' => 'DESC'));
        $newspapers2 = $newspaper2Repository->findBy(array(), array('date' => 'DESC'));
        return $this->render('newspaper/index.html.twig', [
            'newspapers' => $newspapers,
            'newspapers2' => $newspapers2,
        ]);
    }

    /**
     * @Route("/new", name="newspaper_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $newspaper = new Newspaper();
        $newspaper->setDate(new \DateTime('now'));
        $form = $this->createForm(NewspaperType::class, $newspaper);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($newspaper);
            $entityManager->flush();

            return $this->redirectToRoute('newspaper_edit',['id'=>$newspaper->getId()]);
        }

        return $this->render('newspaper/new.html.twig', [
            'newspaper' => $newspaper,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="newspaper_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Newspaper $newspaper): Response
    {
        //manage new newspaper form
        $form = $this->createForm(NewspaperType::class, $newspaper);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('newspaper_index');
        }

        // Manage new subject form
        $newspaperSubject = new NewspaperSubject();
        $formSubject = $this->createForm(NewspaperSubjectType::class, $newspaperSubject);
        $formSubject->handleRequest($request);

        if ($formSubject->isSubmitted() && $formSubject->isValid()  && $formSubject->getData()->getId() == null) {
            $entityManager = $this->getDoctrine()->getManager();
            $newspaperSubject->setNewspaper($newspaper);
            $entityManager->persist($newspaperSubject);
            $entityManager->flush();

            return $this->redirectToRoute('newspaper_edit',['id'=>$newspaper->getId()]);
        }

        return $this->render('newspaper/edit.html.twig', [
            'newspaper' => $newspaper,
            'form' => $form->createView(),
            'formSubject' => $formSubject->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="newspaper_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Newspaper $newspaper): Response
    {
        if ($this->isCsrfTokenValid('delete'.$newspaper->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($newspaper);
            $entityManager->flush();
        }

        return $this->redirectToRoute('newspaper_index');
    }

    /**
     * @Route("/dernier", name="newspaper_show_latest", methods={"GET"})
     */
    public function showLatest(
        Newspaper2Repository $newspaper2Repository,
        NewspaperRepository $newspaperRepository
    ): Response
    {
        //get latest newspaper
        $latestNewspaper = $newspaperRepository->findOneBy([],['date'=>'DESC']);

        //get latest newspaper 2
        $latestNewspaper2 = $newspaper2Repository->findOneBy([],['date'=>'DESC']);

        $filename=null;

        //get the report filename according to the latest file
        if ($latestNewspaper) {
            $filename = $latestNewspaper->getDocument();
        } elseif ($latestNewspaper2) {
            $filename = '/newspaper_'.$latestNewspaper2->getId().'.pdf';
        }

        if ($latestNewspaper!=null && $latestNewspaper2!=null) {
            if ($latestNewspaper->getDate() < $latestNewspaper2->getDate()) {
                $filename = '/newspaper_'.$latestNewspaper2->getId().'.pdf';
            }
        }

        // to being viewed in the Browser
        $publicDirectory = './documents/newspapers/';

        if ($filename) {
            return new BinaryFileResponse($publicDirectory.$filename);
        }

        $this->addFlash('danger', 'Aucun bulletin n\'est enregistré dans le système');
        return $this->redirectToRoute('home');
    }
}
