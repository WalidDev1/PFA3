<?php

namespace App\Repository;

use App\Entity\Trafic;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Trafic|null find($id, $lockMode = null, $lockVersion = null)
 * @method Trafic|null findOneBy(array $criteria, array $orderBy = null)
 * @method Trafic[]    findAll()
 * @method Trafic[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TraficRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Trafic::class);
    }

    // /**
    //  * @return Trafic[] Returns an array of Trafic objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Trafic
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
