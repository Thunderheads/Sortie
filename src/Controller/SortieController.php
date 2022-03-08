<?php

namespace App\Controller;

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
            return $this->render('trip/index.html.twig', [
                'controller_name' => 'SortieController',
            ]);
        }

        /**
         * @Route("/new/", name="creerUneSortie")
         */
        public function creerUneSortie(): Response
        {
            return $this->render('trip/creerUneSortie.html.twig', [
                'controller_name' => 'SortieController',
            ]);
        }

        /**
         * @Route("/show/{id}", name="afficherUneSortie")
         */
        public function afficherUneSortie(): Response
        {
            return $this->render('trip/afficherUneSortie.html.twig', [
                'controller_name' => 'SortieController',
            ]);
        }

        /**
         * @Route("/update/{id}", name="modifierUneSortie")
         */
        public function modifierUneSortie(): Response
        {
            return $this->render('trip/modifierUneSortie.html.twig', [
                'controller_name' => 'SortieController',
            ]);
        }

        /**
         * @Route("/cancel/{id}", name="annulerLaSortie")
         */
        public function annulerLaSortie(): Response
        {
            return $this->render('trip/annulerLaSortie.html.twig', [
                'controller_name' => 'SortieController',
            ]);
        }
    }
