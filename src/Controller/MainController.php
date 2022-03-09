<?php

namespace App\Controller;

use App\Entity\Sortie;
use App\Repository\SortieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="base")
     */
    public function base(): Response
    {


        return $this->render('base.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }

    /**
     * @Route("/home", name="home")
     */
    public function home(SortieRepository $repo): Response
    {
        $co = new Sortie();
        //$form =  $this->createForm(::class, $co);
        //$form->handleRequest($req);

        return $this->render('sortie/home.html.twig', [
            'sorties' => $repo->findAll(),
            //'form' => $form->createView()
        ]);
    }

}
