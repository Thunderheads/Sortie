<?php

namespace App\Repository;

use App\Entity\Campus;
use App\Entity\Participant;
use App\Entity\Sortie;
use App\Form\HomeModele;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\Query\Expr\Join;

/**
 * @method Sortie|null find($id, $lockMode = null, $lockVersion = null)
 * @method Sortie|null findOneBy(array $criteria, array $orderBy = null)
 * @method Sortie[]    findAll()
 * @method Sortie[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SortieRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Sortie::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Sortie $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(Sortie $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * Fonction en charge de trouver les sorties dont la date limite est passée
     * @return float|int|mixed|string
     */
    public function findByDateLimite(){
        $date = new \DateTime('now');
        $queryBuilder = $this->createQueryBuilder('s');
        $queryBuilder
            ->andWhere('s.dateLimiteInscription < :now')
            ->setParameter(':now', $date);
        return $queryBuilder->getQuery()->getResult();
    }

    /**
     * Fonction en charge de trouver les sorties dont la date début est passée
     * @return float|int|mixed|string
     */
    public function findByDateDebut(){
        $date = new \DateTime('now');

        $minutes_to_add = 500;
        $time =  new \DateTime('now');
        $time->add(new \DateInterval('PT' . $minutes_to_add . 'M'));

        $queryBuilder = $this->createQueryBuilder('s');
        $queryBuilder
            ->andWhere('s.dateHeureDebut < :now')
            ->setParameter(':now', $date);
        return $queryBuilder->getQuery()->getResult();
    }
    /**
     * Fonction en charge de réaliser le filtre des sorties en fonction des plusieurs paramètres
     *
     * @param HomeModele $homeModele
     * @param Participant $participant
     * @return float|int|mixed|string
     */
    public function findHome(HomeModele $homeModele, Participant $participant ){

        $dateDebut = $homeModele->getDateDebutRecherche();
        $dateFin = $homeModele->getDateFin();
        $recherche = $homeModele->getRecherche();
        $campusChoisi = $homeModele->getCampus();
        // sorties auxquelles je suis inscrit/e
        $hasRegister = $homeModele->getSortieInscrit();
        $isOrganizer = $homeModele->getSortieOrganisees();
        $isPasted = $homeModele->getSortiePass();
        $isRegister =$homeModele->getSortieNonInscrit();
        $id = $participant->getId();

        //creation d'une requete de base c'est un select.
        $queryBuilder = $this->createQueryBuilder('s');

        // le s fait reference a la classe sortie c'est la premiere lettre du repo
        $queryBuilder->select('s')
            //jointure interne sur campus
            //table campus = s.Campus c'est pour ça qu'on l'alias (c'est comme si on avait fait appelle a la table campus)
            ->innerJoin('s.Campus', 'c')
            ->innerJoin('s.etat', 'e')
            ->leftJoin('s.Participant', 'p')
            //recupere toutes les infos participants
            //->addSelect('p')

            ->andWhere(' s.Campus = :campus')
            ->setParameter(':campus', $campusChoisi)
            //si on veut rajouter la table au select
            //->select('c')
            //regarder que la date de la table sortie soit compris entre date1 et date 2
            ->andWhere('s.dateHeureDebut >= :dateDebut')
            ->setParameter(':dateDebut', $dateDebut)
            ->andWhere('s.dateHeureDebut <= :dateFin ')
            ->setParameter(':dateFin', $dateFin);



            //nom de la sortie doit contenir %recherche%
        if($recherche !== null){
            $queryBuilder
            ->andWhere('s.nom LIKE :recherche')
                ->setParameter('recherche', '%'.$recherche.'%');
                }


            /// sorties dont je suis l'organisateur/trice
        if($isOrganizer){
            $queryBuilder->innerJoin("s.organisateur", "o")
                ->andwhere("o.id = :monid")
                ->setParameter(':monid', $id );
        }

        //quand sorties auxquelles je suis inscrit/e et sorties auxquelles je ne suis pas inscrit/e sont cochées

            // sorties auxquelles je suis inscrit/e
            if($hasRegister )
            {
                $queryBuilder->andWhere(':participant MEMBER OF s.Participant')
                    ->setParameter('participant', $id);
            }

            // sorties auxquelles je ne suis pas inscrit/e
            if($isRegister)
            {
                $queryBuilder->andWhere(':participant NOT MEMBER OF s.Participant')
                    ->setParameter(':participant', $id );
            }



        // sorties passées
        if($isPasted){

            $queryBuilder->andWhere('s.dateLimiteInscription < :dateJour')
                ->setParameter('dateJour', new \DateTime('now'));
        }


        return $queryBuilder->getQuery()->getResult();


    }


    // /**
    //  * @return Sortie[] Returns an array of Sortie objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Sortie
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
