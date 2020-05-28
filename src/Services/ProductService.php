<?php


namespace App\Services;


use App\Entity\Product;
use App\Models\Forms\ProductForm;
use App\Repository\ProductRepository;
use Doctrine\DBAL\Driver\PDOException;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Config\Definition\Exception\Exception;

class ProductService
{
    /**
     * @var ProductRepository $repository
     */
    private $repository;
    /**
     * @var EntityManagerInterface $manager
     */
    private $manager;

    public function __construct(ProductRepository $repository,EntityManagerInterface $manager)
    {
        $this->repository = $repository;
        $this->manager = $manager;
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

    /**
     * @param $productId
     * @param ProductForm $productForm
     * @return void if product.lenght > 0
     * @throws \Exception if product.lenght <= 0 && PDOException is rise && product == null
     */
    public function productEdit($productId, ProductForm $productForm)
    {
        $date = new \DateTime();
        $product = $this->repository->find($productId);
        if($product)
        {
            try {
                $product
                    ->setProduct($productForm->getProduct())
                    ->setDescription($productForm->getDescription())
                    ->setPrice($productForm->getPrice())
                    ->setPicture($productForm->getPicture())
                    ->setAvaibility($productForm->isAvaibility())
                    ->setUpdateAt($date);
            }
            catch (Exception $exception)
            {
                throw new Exception('Unexpected error',500);
            }
        }
        else
        {
            throw new Exception('Product not found',404);
        }
    }
}
