<?php

namespace App\Repository;

use App\Entity\PrixHistorique;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PrixHistorique|null find($id, $lockMode = null, $lockVersion = null)
 * @method PrixHistorique|null findOneBy(array $criteria, array $orderBy = null)
 * @method PrixHistorique[]    findAll()
 * @method PrixHistorique[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PrixHistoriqueRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PrixHistorique::class);
    }

    // /**
    //  * @return PrixHistorique[] Returns an array of PrixHistorique objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?PrixHistorique
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
