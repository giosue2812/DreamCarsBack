<?php


namespace App\Controller;


use App\DTO\PayementDTO;
use App\Services\PayementService;
use App\Utils\DataManipulation;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use OpenApi\Annotations as OA;
use Symfony\Component\Config\Definition\Exception\Exception;

class PayementController extends AbstractFOSRestController
{
    /**
     * @var PayementService $service
     */
    private $service;

    /**
     * PayementController constructor.
     * @param PayementService $service
     */
    public function __construct(PayementService $service)
    {
        $this->service = $service;
    }

    /**
     * @Rest\Get(path="/api/payement")
     * @Rest\View()
     * @return array
     */
    public function getPayementsAction()
    {
        try {
            $payements = $this->service->getPayement();
            return DataManipulation::arrayMap(PayementDTO::class,$payements);
        }
        catch (Exception $exception)
        {
            throw new Exception($exception->getCode(),$exception->getMessage());
        }


    }
}
