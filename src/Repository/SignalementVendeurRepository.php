<?php

namespace App\Repository;

use App\Entity\SignalementVendeur;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method SignalementVendeur|null find($id, $lockMode = null, $lockVersion = null)
 * @method SignalementVendeur|null findOneBy(array $criteria, array $orderBy = null)
 * @method SignalementVendeur[]    findAll()
 * @method SignalementVendeur[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SignalementVendeurRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SignalementVendeur::class);
    }

    // /**
    //  * @return SignalementVendeur[] Returns an array of SignalementVendeur objects
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
    public function findOneBySomeField($value): ?SignalementVendeur
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
