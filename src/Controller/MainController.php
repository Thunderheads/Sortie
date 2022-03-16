<?php

namespace App\Controller;

use App\Entity\Campus;
use App\Entity\Sortie;
use App\Form\HomeModele;
use App\Form\HomeType;
use App\Form\SortieType;
use App\Repository\ParticipantRepository;
use App\Repository\SortieRepository;
use App\Service\ServiceHomePage;
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
            'user'=>$this->getUser()
        ]);
    }


    /**
     * @Route("/home", name="home")
     */
    public function home(ServiceHomePage $service,SortieRepository $sortieRepo, ParticipantRepository $user, Request $req): Response
    {
        $service->updateEtat();
        //creation objet
        $homeModele = new HomeModele();
        $form = $this->createForm(HomeType::class, $homeModele);
        $form->handleRequest($req);

        $filtreSortie = $sortieRepo->findAll();

        if($form->isSubmitted() && $form->isValid()){


            $filtreSortie = $sortieRepo->findHome($homeModele, $this->getUser());


        }

        return $this->render('sortie/home.html.twig', [

            'sorties' => $filtreSortie,
            'form' => $form->createView(),
            'user'=>$this->getUser()

        ]);
    }


}
