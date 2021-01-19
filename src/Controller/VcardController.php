<?php

namespace App\Controller;

use App\Entity\Vcard;
use App\Form\VcardType;
use App\Repository\VcardRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/vcard")
 */
class VcardController extends AbstractController
{
    /**
     * @Route("/", name="vcard_index", methods={"GET"})
     */
    public function index(VcardRepository $vcardRepository): Response
    {
        return $this->render('vcard/index.html.twig', [
            'vcards' => $vcardRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="vcard_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $vcard = new Vcard();
        $form = $this->createForm(VcardType::class, $vcard);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($vcard);
            $entityManager->flush();

            return $this->redirectToRoute('vcard_index');
        }

        return $this->render('vcard/new.html.twig', [
            'vcard' => $vcard,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="vcard_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Vcard $vcard): Response
    {
        $form = $this->createForm(VcardType::class, $vcard);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('vcard_index');
        }

        return $this->render('vcard/edit.html.twig', [
            'vcard' => $vcard,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="vcard_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Vcard $vcard): Response
    {
        if ($this->isCsrfTokenValid('delete'.$vcard->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($vcard);
            $entityManager->flush();
        }

        return $this->redirectToRoute('vcard_index');
    }
}
