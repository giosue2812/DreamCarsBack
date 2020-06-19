<?php

namespace App\Controller;

use App\Services\SaleService;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;
use OpenApi\Annotations as OA;

class SaleController extends AbstractFOSRestController
{
    /**
     * @var SaleService $saleService
     */
    private $saleService;

    /**
     * SaleController constructor.
     * @param SaleService $saleService
     */
    public function __construct(SaleService $saleService)
    {
        $this->saleService = $saleService;
    }

    /**
     * @Rest\Get(path="/api/sales/addCard/{productId}/{userId}")
     * @Rest\View()
     * @OA\Get(
     *     tags={"Card"},
     *     summary="Add product on the card",
     *     path="/sales/addCard/{productId}/{userId}",
     *     security={{"bearerAuth":{}}},
     *     operationId="productId,userId",
     *     @OA\Parameter(
     *          parameter="productId",
     *          name="productId",
     *          in="path",
     *          description="Id for found a Product",
     *          required=true,
     *          @OA\Schema(
     *              type="integer"
     *          )
     *     ),
     *     @OA\Parameter(
     *          parameter="userId",
     *          name="userId",
     *          in="path",
     *          description="Id for found a User",
     *          required=true,
     *          @OA\Schema(
     *              type="integer"
     *          )
     *     ),
     *     @OA\Response(
     *          response="404",
     *          description="No found user or Not found product",
     *          @OA\JsonContent(ref="#/components/schemas/ApiErrorResponseDTO")
     *     ),
     *     @OA\Response(
     *          response="500",
     *          description="Unexpected Eror",
     *          @OA\JsonContent(ref="#/components/schemas/ApiErrorResponseDTO")
     *     ),
     *     @OA\Response(
     *          response="200",
     *          description="Return true"
     *     )
     * )
     * @param Request $request
     * @return bool
     * @throws \Exception
     */
    public function addCardAction(Request $request)
    {
        try {
                return $this->saleService->addCard($request->get('productId'),$request->get('userId'));
        }
        catch (Exception $exception)
        {
            throw new HttpException($exception->getCode(), $exception->getMessage());
        }
    }
}
