<?php

namespace App\Controller;

use App\Entity\Sortie;
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
            //
            return $this->render('sortie/index.html.twig', [ //route du dossier plus fichier
                'controller_name' => 'SortieController',
            ]);
        }

        /**
         * @Route("/new/", name="creerUneSortie")
         */
        public function creerUneSortie(): Response
        {
            return $this->render('sortie/creerUneSortie.html.twig', [
                'controller_name' => 'SortieController',
            ]);
        }

        /**
         * @Route("/show/{id}", name="afficherUneSortie")
         */
        public function afficherUneSortie(Sortie $s): Response
        {
            return $this->render('sortie/afficherUneSortie.html.twig', [
                'sortie' => $s,
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
