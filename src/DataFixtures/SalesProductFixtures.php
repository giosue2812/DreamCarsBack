<?php


namespace App\DataFixtures;


use App\Entity\BeSales;
use App\Entity\PayementType;
use App\Entity\ProductSale;
use App\Repository\ProductRepository;
use App\Repository\UserRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class SalesProductFixtures extends Fixture
{

    /**
     * @var ProductRepository $productRepository
     */
    private $productRepository;

    /**
     * @var UserRepository $userRepository
     */
    private $userRepository;

    /**
     * SalesProductFixtures constructor.
     * @param ProductRepository $productRepository
     * @param UserRepository $userRepository
     */
    public function __construct(ProductRepository $productRepository,UserRepository $userRepository)
    {
        $this->productRepository = $productRepository;
        $this->userRepository = $userRepository;

    }

    /**
     * @inheritDoc
     */
    public function load(ObjectManager $manager)
    {
        $date = new \DateTime();

        $payement = new PayementType();
        $payement->setNamePayement('PayPal');
        $manager->persist($payement);
        $manager->flush();

        $user = $this->userRepository->find(50);
        $product = $this->productRepository->find(27);

        $productSale = new ProductSale();
        $productSale->setPayement($payement);
        $productSale->setUser($user);
        $productSale->setDate($date);
        $productSale->setSold(true);
        $productSale->setIsOnline(true);

        $manager->persist($productSale);
        $manager->flush();

        $beSales = new BeSales();
        $beSales->setProduct($product);
        $beSales->setQuantity(20);
        $beSales->setProductSale($productSale);

        $manager->persist($beSales);
        $manager->flush();
    }
}
