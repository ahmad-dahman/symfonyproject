<?php

namespace App\Repository;

use App\Entity\AutomobileHistory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method AutomobileHistory|null find($id, $lockMode = null, $lockVersion = null)
 * @method AutomobileHistory|null findOneBy(array $criteria, array $orderBy = null)
 * @method AutomobileHistory[]    findAll()
 * @method AutomobileHistory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AutomobileHistoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AutomobileHistory::class);
    }

    // /**
    //  * @return AutomobileHistory[] Returns an array of AutomobileHistory objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?AutomobileHistory
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
