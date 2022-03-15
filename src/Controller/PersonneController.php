<?php

namespace App\Controller;

use App\Entity\Participant;
use App\Form\UserType;
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
     * @Route("/profil/{id}", name="monProfil")
     */
    public function profil(Participant $participant, ParticipantRepository $partRepo, Request $req, SluggerInterface $slugger, EntityManagerInterface $em, UserPasswordHasherInterface $passHach): Response
    {
        //je crée le formulaire

        $formUser = $this->createForm(UserType::class, $participant);
        $formUser->handleRequest($req);
        if ($formUser->isSubmitted() && $formUser->isValid()) {

            $imageDoss = $formUser->get('image')->getData();

                $hashPassword = $formUser->get('password')->getData();
                $participant->setPassword($hashPassword);
                $encodePass = $passHach->hashPassword(
                    $participant,
                    $hashPassword
                );
                $participant->setPassword($encodePass);
                $em->persist($participant);
                $em->flush();

                dump('profilModifier');

            if ($imageDoss) {
                $nomFichier = pathinfo($imageDoss->getClientOriginalName(), PATHINFO_FILENAME);
                $safeNom = $slugger->slug($nomFichier);
                $newNom = $safeNom . '-' . uniqid() . '.' . $imageDoss->guessExtension();

                try {
                    $imageDoss->move(
                        $this->getParameter('img_directory'),
                        $newNom
                    );
                } catch (FileException $e) {
                }
                $participant->setImage($newNom);
                $em->persist($participant);
               $em->flush();
            }

//            return $this->render('sortie/monProfil.html.twig');

        }

        return $this->render('sortie/monProfil.html.twig', [
            'formUser' => $formUser->createView()
        ]);


    }
}
