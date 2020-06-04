<?php


namespace App\Services;


use App\Entity\Product;
use App\Models\Forms\ProductForm;
use App\Models\Forms\ProductSearchForm;
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
    /**
     * @var SupplierService $supplierService
     */
    private $supplierService;

    /**
     * ProductService constructor.
     * @param ProductRepository $repository
     * @param EntityManagerInterface $manager
     * @param CategoryService $categoryService
     * @param SupplierService $supplierService
     */
    public function __construct(ProductRepository $repository,EntityManagerInterface $manager,CategoryService $categoryService,SupplierService $supplierService)
    {
        $this->repository = $repository;
        $this->manager = $manager;
        $this->categoryService = $categoryService;
        $this->supplierService = $supplierService;
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
     * @param ProductForm $productForm
     * @return array if array.lenght > && category == true && supplier == true
     * @throws Exception if category return false or supplier return false or PDOException is rise and array.lenght <= 0
     */
    public function createProduct(ProductForm $productForm)
    {
        $arrayProduct = [];
        $product = new Product();
        $category = $this->categoryService->getCategory($productForm->getCategory()->getName());
        $supplier = $this->supplierService->getSupplier($productForm->getSupplier()->getName());
        $product
            ->setProduct($productForm->getProduct())
            ->setPrice($productForm->getPrice())
            ->setPicture($productForm->getPicture())
            ->setDescription($productForm->getDescription())
            ->setAvaibility($productForm->isAvaibility())
            ->setCategory($category)
            ->setSupplier($supplier);

        try {
            $this->manager->persist($product);
            $this->manager->flush();
            $arrayProduct[] = $product;
            return $arrayProduct;
        }
        catch (PDOException $PDOException)
        {
            throw new Exception('Unexpected error',500);
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
        $supplier = $this->supplierService->getSupplier($productForm->getSupplier()->getName());
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
                    ->setSupplier($supplier)
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

    /**
     * @param $productId
     * @return array if array.lenght > 0
     * @throws Exception if array.lenght <= 0
     */
    public function product($productId)
    {
        $product = $this->repository->find($productId);
        $arrayProduct = [];
        if($product)
        {
            $arrayProduct[] = $product;
            return $arrayProduct;
        }
        else
        {
            throw new Exception('Not found product',404);
        }
    }

    /**
     * @param ProductSearchForm $productSearchForm
     * @return Product[] Product.lenght > 0
     * @throws Exception if Product.lenght <= 0
     */
    public function productSearch(ProductSearchForm $productSearchForm)
    {
        $product = $this->repository->searchProduct($productSearchForm->getKeyWord());
        if($product)
        {
            return $product;
        }
        else
        {
            throw new Exception('Product not found',404);
        }
    }
}
