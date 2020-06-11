<?php


namespace App\Services;


use App\Entity\Supplier;
use App\Repository\SupplierRepository;
use Symfony\Component\Config\Definition\Exception\Exception;

class SupplierService
{
    /**
     * @var SupplierRepository $repository
     */
    private $repository;

    public function __construct(SupplierRepository $supplierRepository)
    {
        $this->repository = $supplierRepository;
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
}
