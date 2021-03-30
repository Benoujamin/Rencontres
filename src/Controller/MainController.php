<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="main_home")
     */
    public function home(): Response
    {
        return $this->render('main/home.html.twig', [

        ]);
    }

    /**
     * @Route("/cgu", name="main_cgu")
     */
    public function cgu(): Response
    {
        return $this->render('main/cgu.html.twig', [

        ]);
    }

    /**
     * @Route("/mentions-legales", name="main_mentions-legales")
     */
    public function mentionsLegales(): Response
    {
        return $this->render('main/mentions-legales.html.twig', [

        ]);
    }
}
