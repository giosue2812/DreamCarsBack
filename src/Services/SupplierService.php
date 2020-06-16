<?php


namespace App\Services;


use App\Entity\Supplier;
use App\Models\Forms\CategoryForm;
use App\Models\Forms\SupplierForm;
use App\Repository\SupplierRepository;
use Doctrine\DBAL\Driver\PDOException;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Config\Definition\Exception\Exception;

class SupplierService
{
    /**
     * @var EntityManagerInterface $manager
     */
    private $manager;
    /**
     * @var SupplierRepository $repository
     */
    private $repository;

    /**
     * SupplierService constructor.
     * @param SupplierRepository $supplierRepository
     * @param EntityManagerInterface $manager
     */
    public function __construct(SupplierRepository $supplierRepository,EntityManagerInterface $manager)
    {
        $this->repository = $supplierRepository;
        $this->manager = $manager;
    }

    /**
     * @return Supplier[] if Supplier.lenght > 0
     * @throws Exception if Supplier.lenght <= 0
     */
    public function getSuppliers()
    {
        $suppliers = $this->repository->findAll();
        if($suppliers)
        {
            return $suppliers;
        }
        else
        {
            throw new Exception('Suppliers not found',404);
        }
    }
    /**
     * @param $supplierName
     * @return Supplier if Supplier != null
     * @throws Exception if Supplier == null
     */
    public function getSupplier($supplierName)
    {
            $supplier = $this->repository->findOneBy(['name'=>$supplierName]);
            if($supplier)
            {
                return $supplier;
            }
            else
            {
                throw new Exception('Supplier not found',404);
            }

    }

    /**
     * @param $supplierId
     * @return array if array.lenght > 0 and $supplier != null
     * @throws Exception if array.lenght <= 0 or $supplier == null
     */
    public function getSupplierId($supplierId)
    {
        $arraySupplier = [];
        $supplier = $this->repository->find($supplierId);
        if($supplier)
        {
            $arraySupplier[] = $supplier;
            return $arraySupplier;
        }
        else
        {
            throw new Exception('Supplier not found',404);
        }
    }

    /**
     * @param SupplierForm $categoryForm
     * @param $categoryId
     * @return Supplier[] Supplier.lenght > 0 and if supplier != null
     * @throws \Exception Supplier.lenght <= 0 or if supplier == null or PDOException is rise
     */
    public function editSupplier(SupplierForm $categoryForm, $categoryId)
    {
        $date = new \DateTime();
        $supplier = $this->repository->find($categoryId);
        if($supplier)
        {
            $supplier
                ->setName($categoryForm->getName())
                ->setStreet($categoryForm->getStreet())
                ->setNumber($categoryForm->getNumber())
                ->setPostalCode($categoryForm->getPostalCode())
                ->setTel($categoryForm->getTel())
                ->setEmail($categoryForm->getEmail())
                ->setCity($categoryForm->getCity())
                ->setCountry($categoryForm->getCountry())
                ->setUpdateAt($date);
                try {
                    $this->manager->flush();
                    return $this->getSuppliers();
                }
                catch (PDOException $exception)
                {
                    throw new Exception('Unexpected Error',500);
                }
            }
        else
        {
            throw new Exception('Supplier not found',404);
        }
    }
}
