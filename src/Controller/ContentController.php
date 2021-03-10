<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Content;
use App\Form\ContentType;
use App\Repository\CategoryRepository;
use App\Repository\ContentRepository;
use App\Repository\Newspaper2Repository;
use App\Repository\NewspaperRepository;
use App\Service\MailSender;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @Route("/content")
 */
class ContentController extends AbstractController
{
    /**
     * @Route("/", name="content_index", methods={"GET"})
     */
    public function index(
        ContentRepository $contentRepository,
        NewspaperRepository $newspaperRepository,
        Newspaper2Repository $newspaper2Repository
    ): Response {
        $newspapers = $newspaperRepository->findBy(array(), array('date' => 'DESC'));
        $newspapers2 = $newspaper2Repository->findBy(array(), array('date' => 'DESC'));

        return $this->render('content/index.html.twig', [
            'contents' => $contentRepository->findBy([], array('date' => 'DESC')),
            'newspapers' => $newspapers,
            'newspapers2' => $newspapers2,
        ]);
    }

    /**
     * @Route("categorie/{id}", name="content_index_category", methods={"GET"})
     */
    public function indexByCategory(
        ContentRepository $contentRepository,
        NewspaperRepository $newspaperRepository,
        Newspaper2Repository $newspaper2Repository,
        Category $category
    ): Response {
        $newspapers = $newspaperRepository->findBy(array(), array('date' => 'DESC'));
        $newspapers2 = $newspaper2Repository->findBy(array(), array('date' => 'DESC'));

        return $this->render('content/index.html.twig', [
            'contents' => $contentRepository->findBy(['category' => $category], array('date' => 'DESC')),
            'newspapers' => $newspapers,
            'newspapers2' => $newspapers2,
        ]);
    }

    /**
     * @Route("/new", name="content_new", methods={"GET","POST"})
     */
    public function new(Request $request, UserInterface $user): Response
    {
        $content = new Content();
        $content->setWriter($user->getName());
        $form = $this->createForm(ContentType::class, $content);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($content);
            $entityManager->flush();

            $this->addFlash('success', 'Votre nouvel article a bien été enregsitré.');

            return $this->redirectToRoute('content_index');
        }

        return $this->render('content/new.html.twig', [
            'content' => $content,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="content_show", methods={"GET"})
     */
    public function show(Content $content, ContentRepository $contentRepository): Response
    {

        //get four random article
        $contents = [];
        $contentCount = $contentRepository->count(array());
        for($i = 0; $i < 4; $i++) {
            $index = rand(0, $contentCount-1);
            $contents[] = $contentRepository->findBy([],[],1, $i)[0];
        }

        return $this->render('content/show.html.twig', [
            'content' => $content,
            'contents' => $contents,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="content_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Content $content, UserInterface $user): Response
    {
        $form = $this->createForm(ContentType::class, $content);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $content->setWriter($user->getName());

            //if the publication date is past (it is already published) update it to today
            if($content->getDate() < new DateTime()) {
                $content->setDate(new DateTime());
            }

            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('success', 'Votre article a bien été modifié');

            return $this->redirectToRoute('content_index');
        }

        return $this->render('content/edit.html.twig', [
            'content' => $content,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="content_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Content $content): Response
    {
        if ($this->isCsrfTokenValid('delete'.$content->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($content);
            $entityManager->flush();
        }

        return $this->redirectToRoute('content_index');
    }

    /**
     * @Route("/{id}/notify", name="content_notify", methods={"GET","POST"})
     */
    public function notify(Content $content, MailSender $mailSender): Response
    {
        $mailSender->notifyContentToMembers($content);

        $this->addFlash(
            'success',
            'Un email a bien été envoyé à tous les abonnés concernant l\'article .'.$content->getTitle()
        );

        return $this->redirectToRoute('content_index');
    }

    /**
     * @Route("/list/category", name="content_categories")
     */
    public function getCategoryList(CategoryRepository $categoryRepository)
    {
        $categories=$categoryRepository->findAll();
        return $this->render('_navbarCategoryItem.html.twig',['categories'=> $categories]);
    }
}
