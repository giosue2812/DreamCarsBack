<?php


namespace App\Controller;


use App\DTO\SuppliersChoiceDTO;
use App\DTO\SuppliersDTO;
use App\Services\SupplierService;
use App\Utils\DataManipulation;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Request;
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

    /**
     * @Rest\Get(path="/api/supplier/{supplierId}")
     * @Rest\View()
     * @OA\Get(
     *     tags={"Supplier"},
     *     path="/supplier/{supplierId}",
     *     security={{"bearerAuth":{}}},
     *     summary="Get a supplier",
     *     operationId="supplier",
     *     @OA\Parameter(
     *          description="Id of supplier",
     *          in="path",
     *          name="supplierId",
     *          required=true,
     *          @OA\Schema(
     *              type="integer",
     *              format="int64"
     *          )
     *     ),
     *     @OA\Response(
     *          response="404",
     *          description="Supplier not found",
     *          @OA\JsonContent(ref="#/components/schemas/ApiErrorResponseDTO")
     *     ),
     *     @OA\Response(
     *          response="500",
     *          description="Unexpected Error",
     *          @OA\JsonContent(ref="#/components/schemas/ApiErrorResponseDTO")
     *     ),
     *     @OA\Response(
     *          response="200",
     *          description="Return a supplier",
     *          @OA\JsonContent(ref="#/components/schemas/SuppliersDTO")
     *     )
     * )
     * @param Request $request
     * @return array
     */
    public function getSupplierByIdAction(Request $request)
    {
        try {
            $supplier = $this->service->getSupplierId($request->get('supplierId'));
            return DataManipulation::arrayMap(SuppliersDTO::class,$supplier);
        }
        catch (Exception $exception)
        {
            throw new HttpException($exception->getCode(),$exception->getMessage());
        }
    }
}
