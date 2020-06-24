<?php


namespace App\Services;


use App\Entity\BeSales;
use App\Entity\ProductSale;
use App\Repository\BeSalesRepository;
use App\Repository\PayementTypeRepository;
use App\Repository\ProductRepository;
use App\Repository\ProductSaleRepository;
use App\Repository\UserRepository;
use Doctrine\DBAL\Driver\PDOException;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Request;
use function Symfony\Component\DependencyInjection\Loader\Configurator\ref;

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
     * @var BeSalesRepository $beSaleRepository
     */
    private $beSaleRepository;

    /**
     * @var PayementTypeRepository $payementRepository
     */
    private $payementRepository;

    /**
     * SaleService constructor.
     * @param UserRepository $userRepository
     * @param ProductRepository $productRepository
     * @param EntityManagerInterface $manager
     * @param ProductSaleRepository $productSaleRepository
     * @param BeSalesRepository $beSaleRepository
     * @param PayementTypeRepository $payementRepository
     */
    public function __construct(UserRepository $userRepository,
                                ProductRepository $productRepository,
                                EntityManagerInterface $manager,
                                ProductSaleRepository $productSaleRepository,
                                BeSalesRepository $beSaleRepository,
                                PayementTypeRepository $payementRepository)
    {
        $this->userRepository = $userRepository;
        $this->productRepository = $productRepository;
        $this->productSaleRepository = $productSaleRepository;
        $this->beSaleRepository = $beSaleRepository;
        $this->manager = $manager;
        $this->payementRepository = $payementRepository;
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
     * @param $username string
     * @return bool if $user != null or if $productSale != null
     * @throws Exception if $user == null or if $productSale == null
     */
    public function getCard($username)
    {
        $user = $this->userRepository->findOneBy(['email'=> $username]);
        if($user)
        {
            $productSale = $this->productSaleRepository->countSaleByUser($user->getId());
            if($productSale)
            {
                return $productSale;
            }
        }
        else
        {
            throw new Exception('Not found user',404);
        }
    }

    /**
     * @param $username String
     * @return BeSales[] Array.lenght > 0 and if user != null and if productSale != null
     * @throws Exception Array.lenght <= 0 or if user == null and  id productSale == null
     */
    public function gatCardDetail($username)
    {
        $user = $this->userRepository->findOneBy(['email'=>$username]);
        if($user)
        {
            $productSale = $this->productSaleRepository->productSaleByUser($user->getId());
            if($productSale)
            {
                return $this->beSaleRepository->findBy(['ProductSale'=>$productSale]);
            }
            else
            {
                throw new Exception('Product Sale not found',404);
            }
        }
        else
        {
            throw new Exception('Not found user',404);
        }

    }

    /**
     * @param $username string
     * @param $payementId int
     * @throws Exception if username == null or payement == null or PDOException is rise or array.lenght <= 0
     * @return array if array.lenght > 0 and username != null or payement != null
     */
    public function confirmCard($username,$payementId)
    {
        $user = $this->userRepository->findOneBy(['email'=>$username]);
        if($user)
        {
            $productSale = $this->productSaleRepository->findBy(['User'=>$user]);
            if($productSale)
            {
                $payment = $this->payementRepository->find($payementId);
                foreach ($productSale as $item)
                {
                    $item->setSold(true);
                    $item->setPayement($payment);
                    try {
                        $this->manager->flush();
                    }
                    catch (PDOException $exception)
                    {
                        throw new Exception('Unexpected Error',500);
                    }
                }
            }
            else
            {
                throw new Exception('Payement not found',404);
            }
        }
        else
        {
            throw new Exception('User not found',404);
        }
        return $productSale;
    }
}
