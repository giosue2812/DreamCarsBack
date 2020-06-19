<?php

namespace App\Repository;

use App\Entity\PayementType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PayementType|null find($id, $lockMode = null, $lockVersion = null)
 * @method PayementType|null findOneBy(array $criteria, array $orderBy = null)
 * @method PayementType[]    findAll()
 * @method PayementType[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PayementTypeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PayementType::class);
    }

    // /**
    //  * @return PayementType[] Returns an array of PayementType objects
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
    public function findOneBySomeField($value): ?PayementType
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
