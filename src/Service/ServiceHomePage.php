<?php

namespace App\Service;
use App\Repository\EtatRepository;
use App\Repository\SortieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Constraints\Date;

/**
 * Service en charge de mettre à jour l'état de la base de données à chaque fois que la page home est appeler
 */
class ServiceHomePage
{
    private EntityManagerInterface $em;
    private SortieRepository $sr;
    private EtatRepository $etatRepo;

    public function __construct(EntityManagerInterface $em, SortieRepository $sr, EtatRepository $etatRepo)
    {
        $this->em = $em;
        $this->sr=$sr;
        $this->etatRepo = $etatRepo;
    }

    /**
     * Fonction en charge de mettre à jour la base de données
     * @param SortieRepository $sortieRepo
     * @return void
     */
    public function updateEtat(){

        //modifier les informations des sorties closes
        $sorties = $this->sr->findByDateLimite();
        $etat = $this->etatRepo->findOneBy(["libelle"=>"Clôturée"]);

        foreach ( $sorties as $sortie){
            $sortie->setEtat($etat);
        }


        //modifier le statut des sorties en cours
        $sorties = $this->sr->findAll();
        $etat = $this->etatRepo->findOneBy(["libelle"=>"Activité en cours"]);
        $timeNow =  new \DateTime('now');

        foreach ( $sorties as $sortie){
            $timeEnd = clone $sortie->getDateHeureDebut();
            $timeEnd->add(new \DateInterval('PT' . $sortie->getDuree() . 'M'));
            if($timeNow >= $sortie->getDateHeureDebut() && $timeEnd > $timeNow){
                $sortie->setEtat($etat);
            }
        }

        $this->em->flush();
    }
}