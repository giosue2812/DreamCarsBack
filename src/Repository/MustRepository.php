<?php

namespace App\Repository;

use App\Entity\Must;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Must|null find($id, $lockMode = null, $lockVersion = null)
 * @method Must|null findOneBy(array $criteria, array $orderBy = null)
 * @method Must[]    findAll()
 * @method Must[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MustRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Must::class);
    }

    // /**
    //  * @return Must[] Returns an array of Must objects
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
    public function findOneBySomeField($value): ?Must
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
