<?php

namespace App\Controller;

use App\Entity\Campus;
use App\Entity\Lieu;
use App\Entity\Sortie;
use App\Form\SortieType;
use App\Repository\SortieRepository;
use phpDocumentor\Reflection\Types\This;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
/**
 * @Route("/trip", name="sortie")
 */
    class SortieController extends AbstractController
    {
        /**
         * @Route("/", name="app_sortie")
         */
        public function index(): Response
        {
            return $this->render('sortie/index.html.twig', [
                'controller_name' => 'SortieController',
            ]);
        }

        /**
         * @Route("/home", name="home")
         */
        public function home(SortieRepository $repo, Request $req): Response
        {
            $co = new Sortie();
            $form =  $this->createForm(SortieType::class, $co);
            $form->handleRequest($req);

            return $this->render('sortie/home.html.twig', [
                'sorties' => $repo->findAll(),
                'form' => $form->createView()
            ]);
        }

        /**
         * @Route("/new/", name="creerUneSortie")
         */
        public function creerUneSortie(Request $req): Response
        {

            //creation d'instance
            $sortie = new  Sortie();

            $sortieForm = $this->createForm(SortieType::class, $sortie);
            $sortieForm->handleRequest($req);

            if ($sortieForm->isSubmitted() && $sortieForm->isValid()) {


                if ($sortieForm->isSubmitted() && $sortieForm->isValid()) {
                    return $this->redirectToRoute('app_main');
                }

                return $this->render('sortie/creerUneSortie.html.twig', [
                    "sortieForm" => $sortieForm->createView()
                ]);
            }
        }

        /**
         * @Route("/show/{id}", name="afficherUneSortie")
         */
        public function afficherUneSortie(Sortie $sortie,SortieRepository $repo): Response
        {
            dd($sortie);
            return $this->render('sortie/afficherUneSortie.html.twig', [
                'sortie' => $sortie,
                'sorties' => $repo->findAll()
            ]);
        }

        /**
         * @Route("/update/{id}", name="modifierUneSortie")
         */
        public function modifierUneSortie(): Response
        {
            return $this->render('sortie/modifierUneSortie.html.twig', [
                'controller_name' => 'SortieController'
            ]);
        }

        /**
         * @Route("/cancel/{id}", name="annulerLaSortie")
         */
        public function annulerLaSortie(Sortie $sortie,SortieRepository $repo): Response
        {
            return $this->render('sortie/annulerLaSortie.html.twig', [
                'sortie'=>$sortie,

            ]);
        }
    }
