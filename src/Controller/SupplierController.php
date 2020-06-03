<?php


namespace App\Controller;


use App\DTO\SuppliersChoiceDTO;
use App\Services\SupplierService;
use App\Utils\DataManipulation;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpKernel\Exception\HttpException;
use OpenApi\Annotations as OA;

class SupplierController extends AbstractFOSRestController
{
    /**
     * @var SupplierService $service
     */
    private $service;

    /**
     * SupplierController constructor.
     * @param SupplierService $service
     */
    public function __construct(SupplierService $service)
    {
        $this->service = $service;
    }

    /**
     * @Rest\Get(path="/api/suppliers")
     * @Rest\View()
     * @OA\Get(
     *     tags={"Supplier"},
     *     path="/suppliers",
     *     security={{"bearerAuth":{}}},
     *     summary="Get a list of choice supplier",
     *     operationId="supplier",
     *     @OA\Response(
     *          response="404",
     *          description="No found suppliers",
     *          @OA\JsonContent(ref="#/components/schemas/ApiErrorResponseDTO")
     *     ),
     *     @OA\Response(
     *          response="200",
     *          description="Return a list of Supplier",
     *          @OA\JsonContent(ref="#/components/schemas/SuppliersChoiceDTO")
     *     )
     * )
     * @return array
     */
    public function getCategoryListAction()
    {
        try {
           $suppliers = $this->service->getSuppliers();
           return DataManipulation::arrayMap(SuppliersChoiceDTO::class,$suppliers);
        }
        catch (Exception $exception)
        {
            throw new HttpException($exception->getCode(), $exception->getMessage());
        }
    }
}
