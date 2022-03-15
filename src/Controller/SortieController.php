<?php

namespace App\Controller;

use App\Entity\Etat;
use App\Entity\Participant;
use App\Entity\Sortie;
use App\Form\AnnulerType;
use App\Form\SortieType;
use App\Form\UpdateSortieType;
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
         * @Route("/new/", name="creerUneSortie")
         */
        public function creerUneSortie(Request $req, EntityManagerInterface $em, ParticipantRepository $participantRepository, EtatRepository $etatRepository): Response
        {

            //creation d'instance
            $sortie = new  Sortie();
            $sortieForm = $this->createForm(SortieType::class, $sortie);
            $sortieForm->handleRequest($req);

            //Si le formulaire est valide et soumis
            if ($sortieForm->isSubmitted() && $sortieForm->isValid()) {

                //permet d'attribuer la sortie à un organisateur
                $sortie->setOrganisateur($this->getUser());

                //si le bouton publier est cliqué
                if($sortieForm->get('Publier')->isClicked()){


                    //etat ouverte comme on choisit de publier
                    $etat = $etatRepository->findOneBy(['libelle' => 'Ouverte']);
                    $sortie->setEtat($etat);


                    $em->persist($sortie);
                    $em->flush();

                    //redirection vers la page d'accueil
                    return $this->redirectToRoute('home');
                }

                //si le bouton Enregistrer est cliqué
                if($sortieForm->get('Enregistrer')->isClicked()){

                    //mise en place de l'état crée
                    $etat = $etatRepository->findOneBy(['libelle' => 'Créée']);
                    $sortie->setEtat($etat);


                    $em->persist($sortie);
                    $em->flush();
                    //redirection vers la page d'accueil
                    return $this->redirectToRoute('home');
                }

                //si le bouton Annuler est cliqué
                if($sortieForm->get('Annuler')->isClicked()){

                    //redirection vers la page d'accueil
                    return $this->redirectToRoute('home');

                }
            }

            return $this->render('sortie/creerUneSortie.html.twig', [
                "sortieForm" => $sortieForm->createView()
            ]);
        }



        /**
         * @Route("/show/{id}", name="afficherUneSortie")
         */
        public function afficherUneSortie(Sortie $sortie,SortieRepository $repo ): Response
        {
            return $this->render('sortie/afficherUneSortie.html.twig', [
                'sortie' => $sortie,
            ]);
        }

        /**
         * @Route("/update/{id}", name="modifierUneSortie")
         */
        public function modifierUneSortie(Request $req, Sortie $sortie, SortieRepository $sortieRepository, EntityManagerInterface $em, ParticipantRepository $participantRepository, EtatRepository $etatRepository): Response
        {


            $sortieForm = $this->createForm(UpdateSortieType::class, $sortie);
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

                if($sortieForm->get('Supprimer')->isClicked()){
                    $em->remove($sortie);
                    $em->flush();
                    return $this->redirectToRoute('sortiehome');
                }
            }
            return $this->render('sortie/modifierUneSortie.html.twig', [
                "sortieForm" => $sortieForm->createView(),
                "sortie" => $sortie
            ]);
        }

        /**
         * @Route("/cancel/{id}", name="annulerLaSortie")
         */
        public function annulerLaSortie(Sortie $sortie,SortieRepository $repo,Request $requestA, EtatRepository $etatrepo, EntityManagerInterface $em): Response
        {
            //je crée mon form avc les parametres dans la classe annulerType
            $annuleForm = $this->createForm(AnnulerType::class);
            $annuleForm->handleRequest($requestA);

            if ($annuleForm->isSubmitted() && $annuleForm->isValid()) {

                //si le bouton Enregistrer est cliqué
                if ($annuleForm->get('Enregistrer')->isClicked()) {

                    //mise en place de l'état annuler
                    $etat = $etatrepo->findOneBy(['libelle' => 'Annulée']);
                    $sortie->setEtat($etat);

                    /**
                     * TODO $motif
                     */

                    $em->persist($sortie);
                    $em->flush();
                    //redirection vers la page d'accueil
                    return $this->redirectToRoute('sortiehome');
                }

                //si le bouton Annuler est cliqué
                if ($annuleForm->get('Annuler')->isClicked()) {

                    //redirection vers la page d'accueil
                    return $this->redirectToRoute('sortiehome');

                }
            }

            return $this->render('sortie/annulerLaSortie.html.twig', [
                'sortie'=>$sortie,
                'annuleForm'=>$annuleForm->createView()

            ]);
        }

    }
