<?php

namespace App\Controller;

use App\Entity\Campus;
use App\Entity\Sortie;
use App\Form\HomeModele;
use App\Form\HomeType;
use App\Form\SortieType;
use App\Repository\SortieRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="base")
     */
    public function base(): Response
    {
        return $this->render('base.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }


    /**
     * @Route("/home", name="home")
     */
    public function home(SortieRepository $sortieRepo, Request $req): Response
    {
        $homeModele = new HomeModele();
        $form = $this->createForm(HomeType::class, $homeModele);
        $form->handleRequest($req);


        return $this->render('sortie/home.html.twig', [
            'sorties' => $sortieRepo->findAll(),
            'form' => $form->createView()
        ]);
    }


}
