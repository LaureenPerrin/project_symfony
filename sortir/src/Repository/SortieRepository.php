<?php

namespace App\Repository;


use App\Entity\Sortie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use function Doctrine\ORM\QueryBuilder;
use function Sodium\add;


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
      * @return Sortie[] Returns an array of Sortie objects
      */

    public function sortiesByCriteres($site, $nomSortie, $dateDebut, $dateFin, $idOrganisateur, $idInscrit, $idNonInscrit, $sortiesPassees)
    {

        $qb = $this->createQueryBuilder('sortie')
            ->leftJoin('sortie.etat', 'etat')
            ->leftJoin("sortie.siteOrganisateur", "campus")
            ->leftJoin("sortie.participantsInscrits", "inscription")
            ->leftJoin("sortie.participantOrganisateur", "participant")
            ->addSelect('sortie');


        if($site != null){
            $qb->andWhere('sortie.siteOrganisateur = :site')
                ->setParameter('site', $site);
        }

        if($nomSortie != null){
            $qb->andWhere('sortie.nom_sortie like :nomSortie')
                ->setParameter('nomSortie', $nomSortie.'%');
        }

        if($dateDebut != null and $dateFin != null){
            $qb->andWhere('sortie.dateCloture BETWEEN :dateDebut AND :dateFin')
                ->setParameter('dateDebut', $dateDebut)
                ->setParameter('dateFin', $dateFin);
        }

        if($idOrganisateur != null){
            $qb->andWhere(' sortie.participantOrganisateur = :organisateur')
                ->setParameter('organisateur', $idOrganisateur);
        }

        if($idInscrit != null){
            $qb->andWhere(' inscription.id = :inscrit')
                ->setParameter('inscrit', $idInscrit);
        }

        if($idNonInscrit != null){
            dump($idNonInscrit);
            /*$qb2 = $this->createQueryBuilder('sortie')
                ->leftJoin('sortie.etat', 'etat')
                ->leftJoin("sortie.siteOrganisateur", "campus")
                ->leftJoin("sortie.participantsInscrits", "inscription")
                ->leftJoin("sortie.participantOrganisateur", "participant")
                ->addSelect('sortie')
                ->andWhere('inscription.id = :idParticipant')
                ->setParameter('idParticipant', $idNonInscrit);

            $qb->andWhere($qb->expr()->notIn('sortie.participantsInscrits', $qb2->getDQL()));*/
        }

        if($sortiesPassees != null){
            $qb->andWhere(' etat.libelle = :sortiePassee')
                ->setParameter('sortiePassee', $sortiesPassees);
        }


        $qb->orderBy('sortie.dateDebut', 'DESC');

        return $qb->getQuery()->getResult();
    }


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
