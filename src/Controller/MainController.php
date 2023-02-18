<?php

namespace App\Controller;

use App\Entity\Info;
use App\Entity\Section;
use App\Form\ContactFormType;
use App\Form\SectionFormType;
use App\Repository\AlaUneRepository;
use App\Repository\InfoRepository;
use App\Repository\InstrumentRepository;
use App\Repository\PrestationRepository;
use App\Repository\SectionRepository;
use App\Service\MailerService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(
        SectionRepository $sectionRepository,
        AlaUneRepository $alaUneRepository
    ): Response
    {

        if ($this->isGranted('ROLE_ADMIN')){

            return $this->redirectToRoute('admin_home');
        }

        $sections=$sectionRepository->findAll();
        $alaUne =$alaUneRepository->findAll();

        return $this->render('main/index.html.twig', [
            'controller_name' => 'MainController',
            'sections' => $sections,
            'alaUne' => $alaUne

        ]);
    }

    #[Route('/instruments', name: 'instruments')]
    public function instruments(
        InstrumentRepository $instrumentRepository
    ): Response
    {
        $instruments = $instrumentRepository->findAll();

        return $this->render('main/instrumentsSurMesure.html.twig', [
            'controller_name' => 'MainController',
            'instruments' => $instruments,
        ]);
    }

    #[Route('/fisherman', name: 'fisherman')]
    public function  fisherman(): Response
    {
        return  $this->render('main/fisherman.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }

    #[Route('/prestations', name: 'prestations')]
    public function  prestations(
        PrestationRepository $prestationRepository,

    ): Response
    {
        $prestations = $prestationRepository->findAll();

        return  $this->render('main/prestations.html.twig', [
            'controller_name' => 'MainController',
            'prestations' => $prestations,
        ]);
    }

    #[Route('/artistes',name: 'artistes')]
    public function artiste(

    ): Response
    {
        return $this->render('main/artistes.html.twig');
    }

    #[Route('/contact', name: 'contact')]
    public function  contact(
        MailerService $mailer,
        Request $request,
        EntityManagerInterface $entityManager
    ): Response
    {

        $info = new info();

        $infoForm = $this->createForm(ContactFormType::class, $info);

        $infoForm->handleRequest($request);

        if ($infoForm->isSubmitted() && $infoForm->isValid()) {

            $nom = $infoForm->get('nom')->getData();
            $prenom = $infoForm->get('prenom')->getData();
            $telephone = $infoForm->get('telephone')->getData();
            $text = $infoForm->get('text')->getData();
            $mail = $infoForm->get('mail')->getData();

            $mailer->sendEmail($nom, $prenom, $text, $mail, $telephone );

            $entityManager->persist($info);
            $entityManager->flush();

            $this->addFlash('success','Votre mail a bien été envoyé !');


            return $this->redirectToRoute('home');

        }elseif ($infoForm->isSubmitted()){
            $this->addFlash('success',"Error: votre mail n'a pas été envoyé !");
        }


        return  $this->render('main/contact.hmtl.twig', [
            'controller_name' => 'MainController',
            'infoForm' => $infoForm->createView(),
        ]);
    }
}
