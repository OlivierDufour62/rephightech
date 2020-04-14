<?php

namespace App\Repository;

use App\Entity\Repstatus;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Repstatus|null find($id, $lockMode = null, $lockVersion = null)
 * @method Repstatus|null findOneBy(array $criteria, array $orderBy = null)
 * @method Repstatus[]    findAll()
 * @method Repstatus[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RepstatusRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Repstatus::class);
    }

    // /**
    //  * @return Repstatus[] Returns an array of Repstatus objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Repstatus
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
