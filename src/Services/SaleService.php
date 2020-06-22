<?php


namespace App\Services;


use App\Entity\BeSales;
use App\Entity\ProductSale;
use App\Repository\ProductRepository;
use App\Repository\ProductSaleRepository;
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
     * @var ProductSaleRepository $productSaleRepository
     */
    private $productSaleRepository;

    /**
     * SaleService constructor.
     * @param UserRepository $userRepository
     * @param ProductRepository $productRepository
     * @param EntityManagerInterface $manager
     * @param ProductSaleRepository $productSaleRepository
     */
    public function __construct(UserRepository $userRepository,ProductRepository $productRepository,EntityManagerInterface $manager,ProductSaleRepository $productSaleRepository)
    {
        $this->userRepository = $userRepository;
        $this->productRepository = $productRepository;
        $this->productSaleRepository = $productSaleRepository;
        $this->manager = $manager;
    }

    /**
     * @param $productId integer
     * @param $username string
     * @return bool if user !=null and if product != null
     * @throws \Exception if user == null or product == null or PDOException is rise
     */
    public function addCard($productId, $username)
    {
        $date = new \DateTime();
        $productSale = new ProductSale();
        $beSale = new BeSales();
        $user = $this->userRepository->findOneBy(['email'=>$username]);
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

    /**
     * @param $userId integer
     * @return bool if $user != null or if $productSale != null
     * @throws Exception if $user == null or if $productSale == null
     */
    public function getCard($userId)
    {
        $user = $this->userRepository->find($userId);
        if($user)
        {
            $productSale = $this->productSaleRepository->findOneBy(['User'=>$user->getId()]);
            if($productSale)
            {
                return true;
            }
            else
            {
                throw new Exception('Product sale not found',404);
            }
        }
        else
        {
            throw new Exception('Not found user',404);
        }
    }
}
