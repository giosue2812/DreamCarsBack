<?php


namespace App\Services;


use App\Entity\BeSales;
use App\Entity\Product;
use App\Entity\ProductSale;
use App\Entity\User;
use App\Repository\ProductRepository;
use App\Repository\UserRepository;
use Doctrine\DBAL\Driver\PDOException;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Config\Definition\Exception\Exception;

class SaleService
{
    /**
     * @var UserRepository $userRepository
     */
    private $userRepository;
    /**
     * @var ProductRepository $productRepository
     */
    private $productRepository;

    /**
     * @var EntityManagerInterface $manager
     */
    private $manager;

    /**
     * SaleService constructor.
     * @param UserRepository $userRepository
     * @param ProductRepository $productRepository
     * @param EntityManagerInterface $manager
     */
    public function __construct(UserRepository $userRepository,ProductRepository $productRepository,EntityManagerInterface $manager)
    {
        $this->userRepository = $userRepository;
        $this->productRepository = $productRepository;
        $this->manager = $manager;
    }

    /**
     * @param $productId integer
     * @param $userId integer
     * @return bool
     * @throws \Exception
     */
    public function addCard($productId, $userId)
    {
        $date = new \DateTime();
        $productSale = new ProductSale();
        $beSale = new BeSales();
        $user = $this->userRepository->find($userId);
        $product = $this->productRepository->find($productId);

        if($user)
        {
            $productSale->setDate($date);
            $productSale->setSold(false);
            $productSale->setUser($user);
            $productSale->setIsOnline(true);
            if($product)
            {
                $beSale->setProductSale($productSale);
                $beSale->setProduct($product);
                $beSale->setQuantity(20);
                try {
                    $this->manager->persist($beSale);
                    $this->manager->persist($productSale);
                    $this->manager->flush();
                    return true;
                }
                catch (PDOException $exception)
                {
                    throw new Exception('Unexpected Error',500);
                }
            }
            else
            {
                throw new Exception('Product not found',404);
            }
        }
        else
        {
            throw new Exception('User not found',404);
        }

    }
}
