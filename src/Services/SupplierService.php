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
     * @param SupplierForm $supplierForm
     * @param $supplierId
     * @return Supplier[] Supplier.lenght > 0 and if supplier != null
     * @throws \Exception Supplier.lenght <= 0 or if supplier == null or PDOException is rise
     */
    public function editSupplier(SupplierForm $supplierForm, $supplierId)
    {
        $date = new \DateTime();
        $supplier = $this->repository->find($supplierId);
        if($supplier)
        {
            $supplier
                ->setName($supplierForm->getName())
                ->setStreet($supplierForm->getStreet())
                ->setNumber($supplierForm->getNumber())
                ->setPostalCode($supplierForm->getPostalCode())
                ->setTel($supplierForm->getTel())
                ->setEmail($supplierForm->getEmail())
                ->setCity($supplierForm->getCity())
                ->setCountry($supplierForm->getCountry())
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

    /**
     * @param $supplierId
     * @return Supplier[] Supplier.lenght > 0 and supplier != null
     * @throws \Exception Supplier.lenght <= 0 or if supplier == null or PDOException is rise
     */
    public function removeSupplier($supplierId)
    {
        $date = new \DateTime();
        $supplier = $this->repository->find($supplierId);
        if($supplier)
        {
            $supplier
                ->setUpdateAt($date)
                ->setDeleteAt($date)
                ->setIsActive(false);
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

    /**
     * @param SupplierForm $supplierForm
     * @return Supplier[] Supplier.lenght > 0 and supplier == null
     * @throws Exception if Supploer.lenght <= 0 or supplier != null
     */
    public function newSupplier(SupplierForm $supplierForm)
    {
        $supplierCheck = $this->repository->findOneBy(['name'=>$supplierForm->getName()]);
        if($supplierCheck)
        {
            throw new Exception('Supplier already exist in the database',404);
        }
        else
        {
            $supplier = new Supplier();
            $supplier
                    ->setName($supplierForm->getName())
                    ->setStreet($supplierForm->getStreet())
                    ->setNumber($supplierForm->getNumber())
                    ->setPostalCode($supplierForm->getPostalCode())
                    ->setTel($supplierForm->getTel())
                    ->setCity($supplierForm->getCity())
                    ->setCountry($supplierForm->getCountry())
                    ->setEmail($supplierForm->getEmail());
            try {
                $this->manager->persist($supplier);
                $this->manager->flush();
                return $this->getSuppliers();
            }
            catch (PDOException $exception)
            {
                throw new Exception('Unexpected Error',500);
            }
        }
    }
}
