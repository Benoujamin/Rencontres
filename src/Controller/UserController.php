<?php

namespace App\Controller;

use App\Entity\Profil;
use App\Entity\ProfilPicture;
use App\Entity\User;
use App\Form\ProfilPictureType;
use App\Form\ProfilType;
use App\Repository\ProfilRepository;
use App\Repository\UserRepository;
use claviska\SimpleImage;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\ByteString;

class UserController extends AbstractController
{
    /**
     *
     * @Route("user{id}/create-profil", name="user_create_profil")
     * @param $id
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @param ProfilRepository $profilRepository
     * @param UserRepository $userRepository
     * @return Response
     */
    public function create($id, Request $request, EntityManagerInterface $entityManager, ProfilRepository $profilRepository, UserRepository $userRepository): Response
    {

        $user = $userRepository->find($id);

        $profil = new Profil();

        $profilForm = $this->createForm(ProfilType::class, $profil);


        $profilForm->handleRequest($request);


        if($profilForm->isSubmitted() && $profilForm->isValid()) {

            $user ->setProfil($profil);

            $entityManager->persist($profil);
            $entityManager->flush();

            $this->addFlash('success', 'Votre profil a été crée');

            return $this->redirectToRoute('user_create_profil', ['id' =>$id]);
        }

        return $this->render('user/createprofil.html.twig', [
            'profilForm' => $profilForm->createView()
        ]);
    }


    /**
     * @Route("/user{id}/add-photo", name="user_create_profil")
     * @param $id
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @param $userRepository
     * @return Response
     */
    public function addPhoto($id, Request $request, EntityManagerInterface $entityManager, UserRepository $userRepository): Response
    {
        $user = $userRepository->find($id);

        $profilPicture = new ProfilPicture();
        $pictureForm = $this->createForm(ProfilPictureType::class, $profilPicture);

        $pictureForm->handleRequest($request);
        if($pictureForm->isSubmitted() && $pictureForm->isValid()) {

            $user->setPhoto($profilPicture);
            /** @var UploadedFile $uploadedFile */
            $uploadedFile = $pictureForm->get('pic')->getData();

            //Genère un nom de fichier sécuritaire
            $newFileName = ByteString::fromRandom(30) . "." . $uploadedFile->guessExtension();

            try {
                $uploadedFile->move($this->getParameter('upload_dir'), $newFileName);
            }catch (\Exception $e) {
                dd($e->getMessage());
            }

            // redimensionne l'image
            $simpleImage = new SimpleImage();
            $simpleImage->fromFile($this->getParameter('upload_dir') . "/$newFileName")
                ->bestFit(300,300)
                ->toFile($this->getParameter('upload_dir') . "/small/$newFileName")
                ->bestFit(1000,1000)
                ->toFile($this->getParameter('upload_dir') . "/big/$newFileName");

            $profilPicture->setFilename($newFileName);
            $entityManager->persist($profilPicture);
            $entityManager->flush();

        }

        return $this->render('user/add-photo.html.twig', ['pictureForm' => $pictureForm->createView()

        ]);
    }
}
