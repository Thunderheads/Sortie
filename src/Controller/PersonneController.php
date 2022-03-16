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
     * @Route("/profil", name="monProfil")
     */
    public function profil(ParticipantRepository $partRepo, Request $req, SluggerInterface $slugger, EntityManagerInterface $em, UserPasswordHasherInterface $passHach): Response
    {

        //je crée le formulaire

        $formUser = $this->createForm(UserType::class, $this->getUser());
        $formUser->handleRequest($req);
        if ($formUser->isSubmitted() && $formUser->isValid()) {

            $imageDoss = $formUser->get('image')->getData();

                $hashPassword = $formUser->get('password')->getData();
                $this->getUser()->setPassword($hashPassword);
                $encodePass = $passHach->hashPassword(
                    $this->getUser(),
                    $hashPassword
                );
                $this->getUser()->setPassword($encodePass);
                $em->persist($this->getUser());
                $em->flush();


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
                $this->getUser()->setImage($newNom);
                $em->persist($this->getUser());
                $em->flush();
            }


        }

        return $this->render('sortie/monProfil.html.twig', [
            'formUser' => $formUser->createView()
        ]);


    }
}
