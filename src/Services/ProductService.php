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
    /**
     * @var CategoryService $categoryService
     */
    private $categoryService;
    public function __construct(ProductRepository $repository,EntityManagerInterface $manager,CategoryService $categoryService)
    {
        $this->repository = $repository;
        $this->manager = $manager;
        $this->categoryService = $categoryService;
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
     * @return array if array.lenght > 0
     * @throws \Exception if product.lenght <= 0 && PDOException is rise && product == null
     */
    public function productEdit($productId, ProductForm $productForm)
    {
        $date = new \DateTime();
        $product = $this->repository->find($productId);
        $category = $this->categoryService->getCategory($productForm->getCategory()->getName());
        if($product)
        {
            $arrayProduct = [];
            try {
                $product
                    ->setProduct($productForm->getProduct())
                    ->setDescription($productForm->getDescription())
                    ->setPrice($productForm->getPrice())
                    ->setPicture($productForm->getPicture())
                    ->setAvaibility($productForm->isAvaibility())
                    ->setCategory($category)
                    ->setUpdateAt($date);
                $this->manager->flush();
                $arrayProduct[] = $product;
                return $arrayProduct;
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
