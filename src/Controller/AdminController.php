<?php

namespace App\Controller;

use App\Entity\AlaUne;
use App\Entity\Section;
use App\Form\SectionFormType;
use App\Repository\AlaUneRepository;
use App\Repository\SectionRepository;
use App\Repository\UserRepository;
use App\Service\FileUploader;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('/admin', name: 'admin')]
class AdminController extends AbstractController
{
    #[Route('/home', name: '_home')]
    public function adminHome(
        Request $request,
        EntityManagerInterface $entityManager,
        SectionRepository $sectionRepository,
        AlaUneRepository $alaUneRepository,
        FileUploader $fileUploader
    ): Response
    {

        $section = new Section();
        $alaUne = new AlaUne();
        $sectionForm = $this->createForm(SectionFormType::class, $section);
        $sectionForm->handleRequest($request);

        $alaUnes=$alaUneRepository->findAll();
        $sections=$sectionRepository->findAll();


        if($sectionForm->isSubmitted() && $sectionForm->isValid()){

            /** @var UploadedFile $image */
            $image = $sectionForm->get('image')->getData();

            if ($image) {
                $brochureFileName = $fileUploader->upload($image);
                $section->setImage($brochureFileName);
            }

            foreach ($sections as $autreSection){

                $sectionPosition = $sectionForm->get('position')->getData();

                $autreSectionPosition = $autreSection->getPosition();

                if ($sectionPosition <= $autreSectionPosition && $section !== $autreSection){

                    $autreSection->setPosition($autreSectionPosition+1);
                    $entityManager->persist($autreSection);
                }
            }

            $instrument = $sectionForm->get('instrument')->getData();

            if($instrument){
                $alaUne->setSection($section);
                $alaUne->setInstrument($instrument);
                $entityManager->persist($alaUne);
            }

            $entityManager->persist($section);
            $entityManager->flush();

            $this->addFlash('success','Nouvelle section créée');

            return $this->redirectToRoute('admin_home');

        }



        return $this->render('main/index.html.twig', [
            'sectionForm' => $sectionForm->createView(),
            'sections' => $sections,
            'alaUnes' => $alaUnes
        ]);

    }

    #[Route('/modifier/{id}', name: '_modifier')]
    public function adminModifier(
        int $id,
        Request $request,
        EntityManagerInterface $entityManager,
        FileUploader $fileUploader,
        SectionRepository $sectionRepository,
    ): Response
    {

        $section = $sectionRepository->findOneBy(['id' => $id]);
        $sections = $sectionRepository->findAll();
        $sectionPreviousPosition = $section->getPosition();

        $sectionForm = $this->createForm(SectionFormType::class, $section);

        $sectionForm->handleRequest($request);

        if($sectionForm->isSubmitted() && $sectionForm->isValid()){

            $uploadImage = $sectionForm->get('image')->getData();

            if ($uploadImage) {

                $fileName = $fileUploader->upload($uploadImage);
                $section->setImage($fileName);
            }

            $sectionPosition = $sectionForm->get('position')->getData();

            foreach ($sections as $autreSection){

                $autreSectionPosition = $autreSection->getPosition();


                if ($sectionPosition === $autreSectionPosition && $section !== $autreSection){

                    $autreSection->setPosition($sectionPreviousPosition);
                    $entityManager->persist($autreSection);
                }
            }

            $entityManager->persist($section);
            $entityManager->flush();

            $this->addFlash('success','La section à été modifiée');

            return $this->redirectToRoute('admin_home');

        }

        return $this->render('admin/modifierSection.html.twig', [
            'sectionForm' => $sectionForm->createView(),
            'id' => $id,
        ]);

    }

    #[Route('/suppr/{id}', name: '_suppr')]
    public function supprSection(
        int $id,
        EntityManagerInterface $entityManager,
        SectionRepository $sectionRepository
    ) : Response
    {
        $section = $sectionRepository->find($id);
        $sections = $sectionRepository->findAll();


        foreach ($sections as $autreSection){

            $sectionPosition = $section->getPosition();

            $autreSectionPosition = $autreSection->getPosition();

            if ($sectionPosition <= $autreSectionPosition && $section !== $autreSection){

                $autreSection->setPosition($autreSectionPosition-1);
                $entityManager->persist($autreSection);
            }
        }

        $entityManager->remove($section);
        $entityManager->flush();

        $this->addFlash('success','La section a été supprimée');

        return $this->redirectToRoute('admin_home');

    }

    #[Route('/user/suppr/{id}', name: '_user_suppr')]
    public function supprUser(
        int $id,
        EntityManagerInterface $entityManager,
        UserRepository $userRepository
    ) : Response
    {
        $user = $userRepository->find($id);

        $entityManager->remove($user);
        $entityManager->flush();

        $this->addFlash('success','L\'utilisateur a bien été supprimée');

        return $this->redirectToRoute('admin_app_register');
    }
}