<?php

namespace App\Controller;

use App\Entity\Participant;
use App\Entity\Sortie;
use App\Form\UserType;
use App\Repository\EtatRepository;
use App\Repository\ParticipantRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class PersonneController extends AbstractController
{

    /**
     * @Route("/profil", name="monProfil")
     */
    public function profil(ParticipantRepository $partRepo, Request $req, SluggerInterface $slugger, EntityManagerInterface $em, UserPasswordHasherInterface $passHach): Response
    {

        //je crée le formulaire

        $formUser = $this->createForm(UserType::class, $this->getUser());
        $formUser->handleRequest($req);

        // si le formulaire est soumis et valide alors
        if ($formUser->isSubmitted() && $formUser->isValid()) {

            //récupère les données d'image du form
            $imageDoss = $formUser->get('image')->getData();

                //récupère le password du form en clair
                $plainPassword = $formUser->get('password')->getData();

                //si le password est remplie, j'update le password et je le 'hash'
                if($plainPassword) {
                    $this->getUser()->setPassword($plainPassword);
                    $encodePass = $passHach->hashPassword(
                        $this->getUser(),
                        $plainPassword
                    );
                    $this->getUser()->setPassword($encodePass);
                }
                $em->persist($this->getUser());
                $em->flush();

                //si j'ai mon dossier image
            if ($imageDoss) {

                //cette condition est nécessaire car le champ d'image n'est pas obligatoire
                //et le fichier doit être traité uniquement lorsqu'un fichier est téléchargé
                $nomFichier = pathinfo($imageDoss->getClientOriginalName(), PATHINFO_FILENAME);

                //inclus en toute sécurité le nom du fichier dans l'URL
                $safeNom = $slugger->slug($nomFichier);
                $newNom = $safeNom . '-' . uniqid() . '.' . $imageDoss->guessExtension();

                //Déplace le fichier dans le répertoire où sont stockées les images
                try {
                    $imageDoss->move(
                        $this->getParameter('img_directory'),
                        $newNom
                    );
                } catch (FileException $e) {
                }
                //update l'image du user (enregistre la récupération du user et envoi
                $this->getUser()->setImage($newNom);
                $em->persist($this->getUser());
                $em->flush();
            }


        }

        return $this->render('sortie/monProfil.html.twig', [
            'formUser' => $formUser->createView()
        ]);


    }

    /**
     * Chemin pour s'inscrire à une sortie
     *
     * @Route("/inscrire/{id}", name="inscrire")
     */
    public function inscrire(Sortie $sortie, EntityManagerInterface $em): Response
    {
        $sortie->getParticipant()->add($this->getUser());
        $em->persist($sortie);
        $em->flush();

        return $this->redirectToRoute('home');
    }


    /**
     * Chemin pour se désinscrire à une sortie
     *
     * @Route("/desinscrire/{id}", name="desinscrire")
     */
    public function desinscrire(Sortie $sortie, EntityManagerInterface $em): Response
    {
        $sortie->getParticipant()->removeElement($this->getUser());
        $em->persist($sortie);
        $em->flush();

        return $this->redirectToRoute('home');
    }

    /**
     * Chemin pour se désinscrire à une sortie
     *
     * @Route("/publier/{id}", name="publier")
     */
    public function publier(Sortie $sortie, EntityManagerInterface $em, EtatRepository $etatRepo): Response
    {
        $etat = $etatRepo->findOneBy(["libelle"=>"Ouverte"]);
        $sortie->setEtat($etat);
        $em->persist($sortie);
        $em->flush();

        return $this->redirectToRoute('home');
    }

    /**
     * @Route("/profil/{id}", name="afficherProfil")
     */
    public function participant(Participant $participant): Response
    {
        return $this->render('sortie/afficherParticipant.html.twig', [
            'participant'=> $participant
        ]);


    }

}
