<?php

namespace App\Controller;

use App\Entity\Campus;
use App\Entity\Sortie;
use App\Form\HomeModele;
use App\Form\HomeType;
use App\Form\SortieType;
use App\Repository\ParticipantRepository;
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
        return $this->redirectToRoute('app_login');
    }


    /**
     * @Route("/home", name="home")
     */
    public function home(SortieRepository $sortieRepo, ParticipantRepository $user, Request $req): Response
    {
        /**
         * @TODO faire en sorte de recuperer l'utilisateur connecté et pas un user aléatoire
         */
        //creation objet
        $homeModele = new HomeModele();
        $form = $this->createForm(HomeType::class, $homeModele);
        $form->handleRequest($req);

        $filtreSortie = $sortieRepo->findAll();

        if($form->isSubmitted() && $form->isValid()){
            $randomUser = $user->find(1);
            $filtreSortie = $sortieRepo->findHome($homeModele, $randomUser);


        }

        return $this->render('sortie/home.html.twig', [

            'sorties' => $filtreSortie,
            'form' => $form->createView()
        ]);
    }


}
