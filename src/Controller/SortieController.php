<?php

namespace App\Controller;

use App\Entity\Sortie;
use App\Form\SortieType;
use http\Client\Request;
use phpDocumentor\Reflection\Types\This;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
         * @Route("/new/", name="creerUneSortie")
         */
        public function creerUneSortie(Request $req): Response
        {
            $sortie = new  Sortie();
            $sortieForm = $this->createForm(SortieType::class, $sortie);

            $sortieForm->handleRequest($req);

            if($sortieForm-> isSubmitted() && $sortieForm->isValid()){
                return $this->redirectToRoute('app_main');
            }

            return $this->render('sortie/creerUneSortie.html.twig', [
                "sortieForm" => $sortieForm->createView()
            ]);
        }

        /**
         * @Route("/show/{id}", name="afficherUneSortie")
         */
        public function afficherUneSortie(): Response
        {
            return $this->render('sortie/afficherUneSortie.html.twig', [
                'controller_name' => 'SortieController',
            ]);
        }

        /**
         * @Route("/update/{id}", name="modifierUneSortie")
         */
        public function modifierUneSortie(): Response
        {
            return $this->render('sortie/modifierUneSortie.html.twig', [
                'controller_name' => 'SortieController',
            ]);
        }

        /**
         * @Route("/cancel/{id}", name="annulerLaSortie")
         */
        public function annulerLaSortie(): Response
        {
            return $this->render('sortie/annulerLaSortie.html.twig', [
                'controller_name' => 'SortieController',
            ]);
        }
    }
