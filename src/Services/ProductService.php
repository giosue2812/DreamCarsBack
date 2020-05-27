<?php


namespace App\Services;


use App\Entity\Product;
use App\Repository\ProductRepository;
use Symfony\Component\Config\Definition\Exception\Exception;

class ProductService
{
    /**
     * @var ProductRepository $repository
     */
    private $repository;

    public function __construct(ProductRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @return Product[] if product.lenght > 0
     * @throws Exception if product.lenght <= 0
     */
    public function productList()
    {
        $products = $this->repository->findAll();
        if($products)
        {
            return $products;
        }
        else
        {
            throw new Exception('Products not found in database',404);
        }

    }
}
