<?php


namespace App\Services;


use App\Entity\PayementType;
use App\Repository\PayementTypeRepository;
use Symfony\Component\Config\Definition\Exception\Exception;

class PayementService
{
    /**
     * @var PayementTypeRepository $repository
     */
    private $repository;

    /**
     * PayementService constructor.
     * @param PayementTypeRepository $repository
     */
    public function __construct(PayementTypeRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @return PayementType[] payement[].lenght > 0
     * @throws Exception payement[].lenght <= 0
     */
    public function getPayement()
    {
        $payement = $this->repository->findAll();
        if($payement)
        {
            return $payement;
        }
        else
        {
            throw new Exception('No found payements',404);
        }
    }
}
