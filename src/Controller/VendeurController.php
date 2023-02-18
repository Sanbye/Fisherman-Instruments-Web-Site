<?php

namespace App\Controller;

use App\Entity\Images;
use App\Entity\Instrument;
use App\Entity\Prestation;
use App\Form\InstrumentFormType;
use App\Form\PrestationFormType;
use App\Repository\InstrumentRepository;
use App\Repository\PrestationRepository;
use App\Service\FileUploader;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('/vendeur', name: 'vendeur')]
class VendeurController extends AbstractController
{
    #[Route('/home', name: '_home')]
    public function vendeurHome(): Response
    {
        return $this->render('main/index.html.twig', [
            'controller_name' => 'VendeurController',
        ]);
    }

    #[Route('/instrument/modifier/{id}', name: '_instrument_modifier')]
    public function modifierInstrument(
        string $id,
        InstrumentRepository $instrumentRepository,
        Request $request,
        EntityManagerInterface $entityManager,
        FileUploader $fileUploader,
    ):Response
    {

        $instrument = $instrumentRepository->findOneBy(['id' => $id]);
        $instruments = $instrumentRepository->findAll();
        $sectionPreviousPosition = $instrument->getPosition();

        $instrumentForm = $this->createForm(InstrumentFormType::class, $instrument);

        $instrumentForm->handleRequest($request);

        if($instrumentForm->isSubmitted() /* && $instrumentForm->isValid() */) {

            /** @var UploadedFile $images */
            $images = $instrumentForm->get('images')->getData();
            $preview = $instrumentForm->get('preview')->getData();

            if ($images) {

                foreach ($images as $image){

                    $fileName = $fileUploader->upload($image);

                    $image = new Images();
                    $image->setNom($fileName);

                    $instrument->addImage($image);

                    $entityManager->persist($image);
                }
            }

            if ($preview){

                $previewImg  = $fileUploader->upload($preview);
                $instrument->setPreview($previewImg);
            }

            $instrumentPosition = $instrumentForm->get('position')->getData();

            foreach ($instruments as $autreInstrument){

                $autreInstrumentPosition = $autreInstrument->getPosition();


                if ($instrumentPosition === $autreInstrumentPosition && $instrument !== $autreInstrument){

                    $autreInstrument->setPosition($sectionPreviousPosition);
                    $entityManager->persist($autreInstrument);
                }
            }


            $entityManager->persist($instrument);
            $entityManager->flush();

            $nomInstrument = $instrument->getNom();

            $this->addFlash('success',"$nomInstrument a bien été modifiée");

            return $this->redirectToRoute('instruments');
        }

        return $this->render('vendeur/vendeurModifierInstrument.html.twig', [
            'controller_name' => 'VendeurController',
            'instrumentForm' => $instrumentForm->createView(),
            'instrument' => $instrument
        ]);
    }

    #[Route('/instrument/ajouter', name: '_instrument_ajouter')]
    public function ajouterInstrument(
        Request $request,
        InstrumentRepository $instrumentRepository,
        EntityManagerInterface $entityManager,
        FileUploader $fileUploader,
    ):Response
    {
        $instrument = new Instrument();
        $instruments = $instrumentRepository->findAll();
        $instrumentForm = $this->createForm(InstrumentFormType::class, $instrument);

        $instrumentForm->handleRequest($request);

        if($instrumentForm->isSubmitted() /* && $instrumentForm->isValid() */) {

            /** @var UploadedFile $images */
            $images = $instrumentForm->get('images')->getData();
            $preview = $instrumentForm->get('preview')->getData();

            if ($images) {

                foreach ($images as $image){

                    $fileName = $fileUploader->upload($image);

                    $image = new Images();
                    $image->setNom($fileName);

                    $instrument->addImage($image);

                    $entityManager->persist($image);
                }
            }

            if ($preview){

                $previewImg  = $fileUploader->upload($preview);
                $instrument->setPreview($previewImg);
            }

            foreach ($instruments as $autreInstrument){

                $sectionPosition = $instrumentForm->get('position')->getData();
                $autreSectionPosition = $autreInstrument->getPosition();

                if ($sectionPosition <= $autreSectionPosition && $instrument !== $autreInstrument){

                    $autreInstrument->setPosition($autreSectionPosition+1);
                    $entityManager->persist($autreInstrument);
                }
            }

            $entityManager->persist($instrument);
            $entityManager->flush();

            $nomInstrument = $instrument->getNom();

            $this->addFlash('success',"$nomInstrument a bien été ajoutée");

            return $this->redirectToRoute('instruments');
        }

        return $this->render('vendeur/vendeurAjouterInstrument.html.twig', [
            'controller_name' => 'VendeurController',
            'instrumentForm' => $instrumentForm->createView(),
            'instrument' => $instrument
        ]);
    }

    #[Route('/instrument/suppr/{id}', name: '_instrument_suppr')]
    public function supprInstrument(
        int $id,
        EntityManagerInterface $entityManager,
        InstrumentRepository $instrumentRepository,
    ) : Response
    {
        $instrument = $instrumentRepository->find($id);
        $instruments = $instrumentRepository->findAll();

        foreach ($instruments as $autreInstrument){

            $instrumentPosition = $instrument->getPosition();
            $autreInstrumentPosition = $autreInstrument->getPosition();

            if ($instrumentPosition <= $autreInstrumentPosition && $instrument !== $autreInstrument){

                $autreInstrument->setPosition($autreInstrumentPosition-1);
                $entityManager->persist($autreInstrument);
            }
        }

        $entityManager->remove($instrument);
        $entityManager->flush();

        $nomInstrument = $instrument->getNom();

        $this->addFlash('success',"$nomInstrument a bien été supprimée");

        return $this->redirectToRoute('instruments');

    }

    #[Route('/prestations/ajouter', name: '_prestations_ajouter')]
    public function ajouterPrestations(
        PrestationRepository $prestationRepository,
        Request $request,
        EntityManagerInterface $entityManager
    ):Response
    {

        $prestations = $prestationRepository->findAll();

        $prestation = new Prestation();
        $prestationForm = $this->createForm(PrestationFormType::class, $prestation);

        $prestationForm->handleRequest($request);

        if ($prestationForm->isSubmitted() && $prestationForm->isValid()){

            $type = $prestationForm->get('type')->getData();
            $prix = $prestationForm->get('prix')->getData();

            $prestation->setType($type);
            $prestation->setPrix($prix);

            foreach ($prestations as $autrePrestation){

                $prestationPosition = $prestationForm->get('position')->getData();

                $autrePrestationPosition = $autrePrestation->getPosition();

                if ($prestationPosition <= $autrePrestationPosition && $prestation !== $autrePrestation){

                    $autrePrestation->setPosition($autrePrestationPosition+1);
                    $entityManager->persist($autrePrestation);
                }
            }

            $entityManager->persist($prestation);
            $entityManager->flush();

            $this->addFlash('success',"La prestation a bien été ajoutée");

            return $this->redirectToRoute('vendeur_prestations_ajouter');
        }

        return $this->render('vendeur/vendeurAjouterPrestations.html.twig', [
            'controller_name' => 'VendeurController',
            'prestationForm' => $prestationForm->createView(),
            'prestation' => $prestation,
            'prestations' => $prestations
        ]);
    }

    #[Route('/prestations/modifier/{id<\d+>?0}', name: '_prestations_modifier')]
    public function modifierPrestations(
        int $id,
        PrestationRepository $prestationRepository,
        Request $request,
        EntityManagerInterface $entityManager
    ):Response
    {

        $prestations = $prestationRepository->findAll();
        $prestation = $prestationRepository->find($id);

        if($id){
            $prestationPreviousPosition = $prestation->getPosition();
        }

        $prestationForm = $this->createForm(PrestationFormType::class, $prestation);

        $prestationForm->handleRequest($request);

        if ($prestationForm->isSubmitted() && $prestationForm->isValid()){

            $type = $prestationForm->get('type')->getData();
            $prix = $prestationForm->get('prix')->getData();

            $prestation->setType($type);
            $prestation->setPrix($prix);

            $prestationPosition = $prestationForm->get('position')->getData();

            foreach ($prestations as $autrePrestation){

                $autrePrestationPosition = $autrePrestation->getPosition();

                if ($prestationPosition === $autrePrestationPosition && $prestation !== $autrePrestation){

                    $autrePrestation->setPosition($prestationPreviousPosition);
                    $entityManager->persist($autrePrestation);
                }
            }

            $entityManager->persist($prestation);
            $entityManager->flush();

            $this->addFlash('success',"La prestation a bien été modifiée");

            return $this->redirectToRoute('vendeur_prestations_modifier');
        }

        return $this->render('vendeur/vendeurModifierPrestation.html.twig', [
            'controller_name' => 'VendeurController',
            'prestationForm' => $prestationForm->createView(),
            'prestation' => $prestation,
            'prestations' => $prestations,
            'id' => $id
        ]);
    }

    #[Route('/prestations/suppr/{id}', name: '_prestations_suppr')]
    public function supprPrestation(
        int $id,
        EntityManagerInterface $entityManager,
        PrestationRepository $prestationRepository,
    ) : Response
    {
        $prestation = $prestationRepository->find($id);
        $prestations = $prestationRepository->findAll();


        foreach ($prestations as $autrePrestation){

            $prestationPosition = $prestation->getPosition();

            $autrePrestationPosition = $autrePrestation->getPosition();

            if ($prestationPosition < $autrePrestationPosition){

                $autrePrestation->setPosition($autrePrestationPosition-1);
                $entityManager->persist($autrePrestation);
            }
        }
        $entityManager->remove($prestation);
        $entityManager->flush();

        $this->addFlash('success',"La prestation a bien été supprimée");

        return $this->redirectToRoute('vendeur_prestations_modifier');

    }
}