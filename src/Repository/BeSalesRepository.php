<?php

namespace App\Repository;

use App\Entity\BeSales;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method BeSales|null find($id, $lockMode = null, $lockVersion = null)
 * @method BeSales|null findOneBy(array $criteria, array $orderBy = null)
 * @method BeSales[]    findAll()
 * @method BeSales[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BeSalesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BeSales::class);
    }

    /**
     * @param $productSaleId
     * @return array
     */
    public function beSaleByProductSale($productSaleId): array
    {
        return $this->createQueryBuilder('p')
            ->where('p.ProductSale = :val')
            ->setParameter('val',$productSaleId)
            ->getQuery()
            ->getResult();
    }
    // /**
    //  * @return BeSales[] Returns an array of BeSales objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('b.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?BeSales
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
