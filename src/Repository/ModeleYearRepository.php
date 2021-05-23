<?php

namespace App\Repository;

use App\Entity\ModeleYear;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ModeleYear|null find($id, $lockMode = null, $lockVersion = null)
 * @method ModeleYear|null findOneBy(array $criteria, array $orderBy = null)
 * @method ModeleYear[]    findAll()
 * @method ModeleYear[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ModeleYearRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ModeleYear::class);
    }

    // /**
    //  * @return ModeleYear[] Returns an array of ModeleYear objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ModeleYear
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
