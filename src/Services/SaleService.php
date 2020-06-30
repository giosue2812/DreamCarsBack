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
     * @param $qty
     * @return bool if user !=null and if product != null
     * @throws \Exception if user == null or product == null or PDOException is rise
     */
    public function addCard($productId, $username,$qty)
    {
        $productSale = new ProductSale();
        $beSale = new BeSales();
        $user = $this->userRepository->findOneBy(['email'=>$username]);
        $product = $this->productRepository->find($productId);

        if($user)
        {
            $productSale->setSold(false);
            $productSale->setUser($user);
            $productSale->setIsOnline(true);
            if($product)
            {
                $beSale->setProductSale($productSale);
                $beSale->setProduct($product);
                $beSale->setQuantity($qty);
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
     * @return array if not productSale found
     * @throws Exception if user == null and  id productSale == null
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
                return [];
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
     * @return boolean true if username != null or payement != null
     * @throws \Exception if username == null or payement == null or PDOException is rise
     */
    public function confirmCard($username,$payementId)
    {
        $date = new \DateTime();
        $user = $this->userRepository->findOneBy(['email'=>$username]);
        if($user)
        {
            $productSale = $this->productSaleRepository->findBy(['User'=>$user]);
            if($productSale)
            {
                $payment = $this->payementRepository->find($payementId);
                foreach ($productSale as $item)
                {
                    $item->setDate($date);
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
        return true;
    }

    /**
     * @param $username
     * @return array
     */
    public function getSummaryOrder($username)
    {
        $user = $this->userRepository->findOneBy(['email'=>$username]);
        $productSaleId = $this->productSaleRepository->summaryOrder($user->getId());
        $beSale = $this->beSaleRepository->findBy(['ProductSale'=>$productSaleId]);
        if($user and $productSaleId and $beSale)
        {
            return $beSale;
        }
        else
        {
            throw new Exception('Not found product sale',404);
        }
    }

    /**
     * @param $productSaleId integer
     * @return array if true and $beSale != null and $productSale != null
     * @throws Exception if false or $beSale == null and $productSale == null or PDOException is rise
     */
    public function removeProductFromCard($productSaleId,$username)
    {
        $beSale = $this->beSaleRepository->findOneBy(['ProductSale'=>$productSaleId]);
        $productSale = $this->productSaleRepository->findOneBy(['id'=>$productSaleId]);
        if($beSale and $productSaleId)
        {
            try {
                $this->manager->remove($beSale);
                $this->manager->remove($productSale);
                $this->manager->flush();
                return $this->gatCardDetail($username);
            }
            catch (PDOException $exception)
            {
                throw new Exception('Unexpected Error',500);
            }
        }
        else
        {
            throw new Exception('No found product on card',404);
        }
    }
}
