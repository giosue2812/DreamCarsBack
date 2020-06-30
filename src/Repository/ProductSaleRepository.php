<?php

namespace App\Repository;

use App\Entity\ProductSale;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ProductSale|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProductSale|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProductSale[]    findAll()
 * @method ProductSale[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductSaleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProductSale::class);
    }

    /**
     * @param $userID
     * @return array
     */
    public function productSaleByUser($userID): array
    {
        return $this->createQueryBuilder('p')
            ->where('p.User = :val')
            ->andWhere('p.Payement IS NULL')
            ->setParameter('val',$userID)
            ->getQuery()
            ->getResult();
    }

    public function countSaleByUser($userID):int
    {
        $qb = $this->createQueryBuilder('p');
        return $qb
            ->select('count(p.id)')
            ->where('p.User = :val')
            ->andWhere('p.Payement IS NULL')
            ->setParameter('val',$userID)
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function summaryOrder($userID):array
    {
        return $this->createQueryBuilder('p')
            ->where('p.User = :val')
            ->andWhere('p.Payement IS NOT    NULL')
            ->setParameter('val',$userID)
            ->getQuery()
            ->getResult();
    }
    // /**
    //  * @return ProductSale[] Returns an array of ProductSale objects
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
    public function findOneBySomeField($value): ?ProductSale
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
