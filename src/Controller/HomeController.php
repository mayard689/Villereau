<?php

namespace App\Controller;

use App\Entity\NewsletterEmail;
use App\Form\NewsletterEmailType;
use App\Repository\ContentRepository;
use App\Repository\EventRepository;
use App\Repository\NewsletterEmailRepository;
use App\Repository\ReportRepository;
use App\Service\MeteoCH;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
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
                //make $s a random string
                for ($secret = '', $i = 0, $z = strlen($a = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789')-1; $i != 32; $x = rand(0,$z), $secret .= $a{$x}, $i++);

                $newsletterEmail->setDate(new DateTime());
                $newsletterEmail->setSecret($secret);

                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($newsletterEmail);
                $entityManager->flush();

                $this->addFlash('success', 'Votre inscription à la newsletter a été enregistrée');

                $email = (new Email())
                    ->from($this->getParameter("mailer_from"))
                    ->to($newsletterEmail->getEmail())
                    ->subject('Newsletter de Villereau')
                    ->html($this->renderView('email/inscription.html.twig', [
                        'secret' => $secret,
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
     * @Route("/stop-email/{secret}", name="confirmStopPub")
     */
    public function confirmStopPub(
        String $secret,
        NewsletterEmailRepository $newsletterEmailRepository,
        EntityManagerInterface $entityManager
    ) {
        $email = $newsletterEmailRepository->findOneBy(['secret'=>$secret]);

        if ($email) {
            $entityManager->remove($email);
            $entityManager->flush();

            $this->addFlash('success', 'Vous avez été désinscrit de la liste de diffusion.');
        }

        return $this->redirectToRoute('home');
    }

    /**
     * @Route("/meteo", name="home_weather")
     */
    public function currentWeather(MeteoCH $meteoCH)
    {
        $weatherData = $meteoCH->getWeather();

        $iconURL = null;
        if($weatherData) {
            $iconURL = $meteoCH->getCurrentIcon($weatherData);
        }

        return $this->render('home/_weatherWidget.html.twig', [
            'iconURL' => $iconURL,
        ]);
    }
}
