<?php

namespace App\Controller;

use App\Entity\ReportSubject;
use App\Form\ReportSubjectType;
use App\Repository\ReportSubjectRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/report/subject")
 */
class ReportSubjectController extends AbstractController
{
    /**
     * @Route("/", name="report_subject_index", methods={"GET"})
     */
    public function index(ReportSubjectRepository $reportSubjectRepository): Response
    {
        return $this->render('report_subject/index.html.twig', [
            'report_subjects' => $reportSubjectRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="report_subject_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $reportSubject = new ReportSubject();
        $form = $this->createForm(ReportSubjectType::class, $reportSubject);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($reportSubject);
            $entityManager->flush();

            return $this->redirectToRoute('report_subject_index');
        }

        return $this->render('report_subject/new.html.twig', [
            'report_subject' => $reportSubject,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="report_subject_show", methods={"GET"})
     */
    public function show(ReportSubject $reportSubject): Response
    {
        return $this->render('report_subject/show.html.twig', [
            'report_subject' => $reportSubject,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="report_subject_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, ReportSubject $reportSubject): Response
    {
        $form = $this->createForm(ReportSubjectType::class, $reportSubject);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('report_subject_index');
        }

        return $this->render('report_subject/edit.html.twig', [
            'report_subject' => $reportSubject,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="report_subject_delete", methods={"DELETE"})
     */
    public function delete(Request $request, ReportSubject $reportSubject): Response
    {
        if ($this->isCsrfTokenValid('delete'.$reportSubject->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($reportSubject);
            $entityManager->flush();
        }

        return $this->redirectToRoute('report_edit',['id'=>$reportSubject->getReport()->getId()]);
    }
}
