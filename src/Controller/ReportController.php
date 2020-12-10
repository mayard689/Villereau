<?php

namespace App\Controller;

use App\Entity\Report;
use App\Entity\ReportSubject;
use App\Form\ReportSubjectType;
use App\Form\ReportType;
use App\Repository\ReportRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/report")
 */
class ReportController extends AbstractController
{
    /**
     * @Route("/", name="report_index", methods={"GET"})
     */
    public function index(ReportRepository $reportRepository): Response
    {
        $reports = $reportRepository->findBy(array(), array('date' => 'DESC'));
        return $this->render('report/index.html.twig', [
            'reports' => $reports,
        ]);
    }

    /**
     * @Route("/new", name="report_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $report = new Report();
        $report->setDate(new \DateTime('now'));
        $form = $this->createForm(ReportType::class, $report);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($report);
            $entityManager->flush();

            return $this->redirectToRoute('report_edit',['id'=>$report->getId()]);
        }

        return $this->render('report/new.html.twig', [
            'report' => $report,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/dernier", name="report_show_latest", methods={"GET"})
     */
    public function showLatest(Report $report): Response
    {
        return $this->render('report/show.html.twig', [
            'report' => $report,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="report_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Report $report): Response
    {
        //manage new report form
        $form = $this->createForm(ReportType::class, $report);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('report_index');
        }

        // Manage new subject form
        $reportSubject = new ReportSubject();
        $formSubject = $this->createForm(ReportSubjectType::class, $reportSubject);
        $formSubject->handleRequest($request);

        if ($formSubject->isSubmitted() && $formSubject->isValid()  && $formSubject->getData()->getId() == null) {
            $entityManager = $this->getDoctrine()->getManager();
            $reportSubject->setReport($report);
            $entityManager->persist($reportSubject);
            $entityManager->flush();

            return $this->redirectToRoute('report_edit',['id'=>$report->getId()]);
        }

        return $this->render('report/edit.html.twig', [
            'report' => $report,
            'form' => $form->createView(),
            'formSubject' => $formSubject->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="report_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Report $report): Response
    {
        if ($this->isCsrfTokenValid('delete'.$report->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($report);
            $entityManager->flush();
        }

        return $this->redirectToRoute('report_index');
    }
}
