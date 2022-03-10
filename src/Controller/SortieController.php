<?php

namespace App\Controller;

use App\Entity\Etat;
use App\Entity\Participant;
use App\Entity\Sortie;
use App\Form\SortieType;
use App\Repository\EtatRepository;
use App\Repository\ParticipantRepository;
use App\Repository\SortieRepository;
use Doctrine\ORM\EntityManagerInterface;
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
            $form = $this->createForm(SortieType::class, $co);
            $form->handleRequest($req);

            return $this->render('sortie/home.html.twig', [
                'sorties' => $repo->findAll(),
                'form' => $form->createView()
            ]);
        }

        /**
         * @Route("/new/", name="creerUneSortie")
         */
        public function creerUneSortie(Request $req, EntityManagerInterface $em, ParticipantRepository $participantRepository, EtatRepository $etatRepository): Response
        {

            /**
             * @TODO pour la creation regarder l'heure elle est pas correcte en base de données
             */
            //creation d'instance
            $sortie = new  Sortie();
            $sortieForm = $this->createForm(SortieType::class, $sortie);
            $sortieForm->handleRequest($req);

            //Si le formulaire est valide et soumis
            if ($sortieForm->isSubmitted() && $sortieForm->isValid()) {

                //permet d'attribuer la sortie à un organisateur
                $organisateur = $participantRepository->find(1);
                $sortie->setOrganisateur($organisateur);

                //si le bouton publier est cliqué
                if($sortieForm->get('Publier')->isClicked()){

                    //etat ouverte comme on choisit de publier
                    $etat = $etatRepository->findOneBy(['libelle' => 'Ouverte']);
                    $sortie->setEtat($etat);


                    $em->persist($sortie);
                    $em->flush();

                    //redirection vers la page d'accueil
                    return $this->redirectToRoute('sortiehome');
                }

                //si le bouton Enregistrer est cliqué
                if($sortieForm->get('Enregistrer')->isClicked()){

                    //mise en place de l'état crée
                    $etat = $etatRepository->findOneBy(['libelle' => 'Créée']);
                    $sortie->setEtat($etat);


                    $em->persist($sortie);
                    $em->flush();
                    //redirection vers la page d'accueil
                    return $this->redirectToRoute('sortiehome');
                }

                //si le bouton Annuler est cliqué
                if($sortieForm->get('Annuler')->isClicked()){

                    //redirection vers la page d'accueil
                    return $this->redirectToRoute('sortiehome');

                }
            }

            return $this->render('sortie/creerUneSortie.html.twig', [
                "sortieForm" => $sortieForm->createView()
            ]);
        }



        /**
         * @Route("/show/{id}", name="afficherUneSortie")
         */
        public function afficherUneSortie($id,SortieRepository $repo): Response
        {
            $sortie = $repo->find($id);

            return $this->render('sortie/afficherUneSortie.html.twig', [
                'sortie' => $sortie,
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
