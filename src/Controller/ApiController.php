<?php

namespace App\Controller;

use App\Entity\Lieu;
use App\Repository\LieuRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ApiController extends AbstractController
{
    /**
     * Fonction en charge de recuperer le lieu associé à l'id
     * @Route ("/lieu/{id}", name="api_lieu_id", methods={"GET"})
     */
    public function unLieu(Lieu $lieu, LieuRepository $lieuRepo):Response
    {
        //$lieu = $lieuRepo->findBy($lieu->getId());
        // passer des groupes permet de selectioner les données que l'on veut renvoyer
        // penser à ajouter dans la classe le decorateur
        // @Groups("lieux")
        // sur les variables à afficher
        // si une variables est de type objet (donc contient des attributs)
        // l'annoté avec @Groups("lieux")
        // ensuite à l'interieur de la classe mettre
        // @Groups("lieux")
        // sur les valeurs que l'on souhaite récupérer
        return $this->json($lieu,200, [],['groups'=>'lieux']);
    }
}
