<?php

namespace App\Controller;

use App\Entity\NewsletterEmail;
use App\Form\NewsletterEmailType;
use App\Repository\ContentRepository;
use App\Repository\EventRepository;
use App\Repository\ReportRepository;
use App\Service\MeteoCH;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(
        Request $request,
        EventRepository $eventRepository,
        ContentRepository $contentRepository,
        ReportRepository $reportRepository,
        MailerInterface $mailer
    ): Response {

        // Manage newsletter email
        $newsletterEmail = new NewsletterEmail();
        $newsletterForm = $this->createForm(NewsletterEmailType::class, $newsletterEmail);
        $newsletterForm->handleRequest($request);

        if ($newsletterForm->isSubmitted()) {
            if ($newsletterForm->isValid()) {

                $newsletterEmail->setDate(new DateTime());
                $entityManager = $this->getDoctrine()->getManager();

                $entityManager->persist($newsletterEmail);
                $entityManager->flush();

                $this->addFlash('success', 'Votre inscription à la newsletter a été enregistrée');

                $email = (new Email())
                    ->from('doc-albert@laposte.net')
                    ->to($newsletterEmail->getEmail())
                    ->subject('Newsletter de Villereau')
                    ->html($this->renderView('email/inscription.html.twig', [
                        'destination' => $newsletterEmail->getEmail()
                    ]));

                $mailer->send($email);

                return $this->redirectToRoute('home');
            }else{
                $this->addFlash('danger', 'Votre inscription à la newsletter n\'a pas été enregistrée car les données fournies présentent un problème.');
            }
        }

        //manage events
        $events = $eventRepository->findComming(3);

        //manage content (articles)
        $contents= $contentRepository->findComming(4,0);

        //manage latest report
        $latestReport = $reportRepository->findOneBy([],['date'=>'DESC']);

        return $this->render('home/index.html.twig', [
            'events' => $events,
            'contents' => $contents,
            'newsletterForm' => $newsletterForm->createView(),
            'latestReport' => $latestReport,
        ]);
    }

    /**
     * @Route("/meteo", name="home_weather")
     */
    public function currentWeather(MeteoCH $meteoCH)
    {
        $weatherData = $meteoCH->getWeather();
        $iconURL = $meteoCH->getCurrentIcon($weatherData);

        return $this->render('home/_weatherWidget.html.twig', [
            'iconURL' => $iconURL,
        ]);
    }

    /**
     * @Route("/unregister", name="unregister")
     */
    public function unregister()
    {

    }
}
