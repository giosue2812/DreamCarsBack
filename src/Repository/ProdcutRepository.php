<?php

namespace App\Repository;

use App\Entity\Prodcut;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Prodcut|null find($id, $lockMode = null, $lockVersion = null)
 * @method Prodcut|null findOneBy(array $criteria, array $orderBy = null)
 * @method Prodcut[]    findAll()
 * @method Prodcut[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProdcutRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Prodcut::class);
    }

    // /**
    //  * @return Prodcut[] Returns an array of Prodcut objects
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
    public function findOneBySomeField($value): ?Prodcut
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
