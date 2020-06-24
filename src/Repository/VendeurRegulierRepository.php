<?php

namespace App\Repository;

use App\Entity\VendeurRegulier;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method VendeurRegulier|null find($id, $lockMode = null, $lockVersion = null)
 * @method VendeurRegulier|null findOneBy(array $criteria, array $orderBy = null)
 * @method VendeurRegulier[]    findAll()
 * @method VendeurRegulier[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VendeurRegulierRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, VendeurRegulier::class);
    }

    // /**
    //  * @return VendeurRegulier[] Returns an array of VendeurRegulier objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('v.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?VendeurRegulier
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
