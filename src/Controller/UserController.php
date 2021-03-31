<?php

namespace App\Controller;

use App\Entity\Preference;
use App\Entity\Profil;
use App\Entity\ProfilPicture;
use App\Entity\User;
use App\Form\PreferenceType;
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
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\String\ByteString;

class UserController extends AbstractController
{
    /**
     *
     * @Route("/user/create-profil", name="user_create_profil")
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @param ProfilRepository $profilRepository
     * @param UserRepository $userRepository
     * @param TokenInterface $token
     * @return Response
     */
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {


        $user = $this->getUser();

        $profil = new Profil();

        $profilForm = $this->createForm(ProfilType::class, $profil);


        $profilForm->handleRequest($request);


        if($profilForm->isSubmitted() && $profilForm->isValid()) {

            $user ->setProfil($profil);
            $entityManager->persist($profil);
            $entityManager->flush();


            return $this->redirectToRoute('user_add_photo');
        }

        return $this->render('user/createprofil.html.twig', [
            'profilForm' => $profilForm->createView()
        ]);
    }


    /**
     * @Route("/user/add-photo", name="user_add_photo")
     * @param $id
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @param UserRepository $userRepository
     * @param TokenInterface $token
     * @return Response
     * @throws \Exception
     */
    public function addPhoto(Request $request, EntityManagerInterface $entityManager, UserRepository $userRepository): Response
    {

        /** @var User $user */
        $user = $this->getUser();

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


            return $this->redirectToRoute('main_home');

        }

        return $this->render('user/add-photo.html.twig', ['pictureForm' => $pictureForm->createView()

        ]);
    }

    /**
     * @Route("/user/profile", name="user_profil")
     */
    public function showProfile(): Response
    {
        /** @var User $user */
        $user = $this->getUser();

        return $this->render('user/profil.html.twig', [
            "user" => $user
        ]);
    }

    /**
     * @Route("/user/set-preferences", name="user_set_preferences")
     */
    public function setPreferences(Request $request, EntityManagerInterface $entityManager): Response
    {

        $preference = new Preference();
        $preferenceForm = $this->createForm(PreferenceType::class, $preference);

        $preferenceForm->handleRequest($request);

        if($preferenceForm->isSubmitted() && $preferenceForm->isValid()) {

            // TO DO : $user->setpreferences($preference)

            $entityManager->persist($preference);
            $entityManager->flush();

            $this->addFlash('danger', 'Votre profil a bien été crée !');
            return $this->redirectToRoute('main_home');
        }


        return $this->render('user/set-preferences.html.twig', [
            'preferenceForm' => $preferenceForm->createView()
        ]);
    }
}
