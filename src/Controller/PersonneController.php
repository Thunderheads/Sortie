<?php

namespace App\Controller;

use App\Entity\Participant;
use App\Form\SortieType;
use App\Form\UserType;
use App\Repository\ParticipantRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class PersonneController extends AbstractController
{

    /**
     * @Route("/profil/{id}", name="monProfil")
     */
    public function profil(Participant $particpant, ParticipantRepository $partRepo, Request $req, SluggerInterface $slugger): Response
    {
        //je crée le formulaire
        $formUser = $this->createForm(UserType::class, $particpant);
        $formUser->handleRequest($req);
        if ($formUser->isSubmitted() && $formUser->isValid()) {
            $imageDoss = $formUser->get('image')->getData();
//                $hashPassword = $formUser->get($particpant)->getPassword();
//
//                $particpant->setPassword($hashPassword);
            if ($imageDoss) {
                $nomFichier = pathinfo($imageDoss->getClientOriginalName(), PATHINFO_FILENAME);
                $safeNom = $slugger->slug($nomFichier);
                $newNom = $safeNom . '-' . uniqid() . '.' . $imageDoss->guessExtension();
                try {
                    $imageDoss->move(
                        $this->getParameter('img_drectory'),
                        $newNom
                    );
                } catch (FileException $e) {
                }
                $particpant->setImage($newNom);
            }
            return $this->redirectToRoute('home');
        }
//            $em = $this->getUser();
//            $em->persist($user);
//            $em->flush();
        return $this->render('sortie/monProfil.html.twig', [
            'formUser' => $formUser->createView()
        ]);


    }
}
