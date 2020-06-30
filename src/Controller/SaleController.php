<?php

namespace App\Controller;

use App\DTO\CountCardSaleDTO;
use App\DTO\ProductSaleDTO;
use App\DTO\SummaryOfProductSaleDTO;
use App\Entity\ProductSale;
use App\Services\SaleService;
use App\Utils\DataManipulation;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;
use OpenApi\Annotations as OA;
use Symfony\Component\VarDumper\Cloner\Data;

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
     * @Rest\Get(path="/api/sales/addCard/{productId}/{username}/{qty}")
     * @Rest\View()
     * @OA\Get(
     *     tags={"Card"},
     *     summary="Add product on the card",
     *     path="/sales/addCard/{productId}/{userId}/{qty}",
     *     security={{"bearerAuth":{}}},
     *     operationId="productId,username",
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
     *          parameter="username",
     *          name="username",
     *          in="path",
     *          description="Id for found a User",
     *          required=true,
     *          @OA\Schema(
     *              type="string"
     *          )
     *     ),
     *     @OA\Response(
     *          response="404",
     *          description="No found user",
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
                return $this->saleService->addCard($request->get('productId'),$request->get('username'),$request->get('qty'));
        }
        catch (Exception $exception)
        {
            throw new HttpException($exception->getCode(), $exception->getMessage());
        }
    }

    /**
     * @Rest\Get(path="/api/sales/card/{username}")
     * @Rest\View()
     * @OA\Get(
     *     tags={"Card"},
     *     summary="Get card user",
     *     path="/sales/card/{username}",
     *     security={{"bearerAuth":{}}},
     *     operationId="userId",
     *     @OA\Parameter(
     *         parameter="username",
     *         name="username",
     *         in="path",
     *         description="username to get card",
     *         required=true,
     *         @OA\Schema(
     *              type="string"
     *         )
     *     ),
     *     @OA\Response(
     *          response="404",
     *          description="User not found or Product sale not found",
     *          @OA\JsonContent(ref="#/components/schemas/ApiErrorResponseDTO")
     *     ),
     *     @OA\Response(
     *          response="200",
     *          description="Return count",
     *          @OA\JsonContent(ref="#/components/schemas/CountCardSaleDTO")
     *     )
     * )
     * @param Request $request
     * @return CountCardSaleDTO
     */
    public function getCartAction(Request $request)
    {
        try {
            $count = $this->saleService->getCard($request->get('username'));
            return new CountCardSaleDTO($count);
        }
        catch (Exception $exception)
        {
            throw new HttpException($exception->getCode(), $exception->getMessage());
        }
    }

    /**
     * @Rest\Get(path="/api/sales/cardList/{username}")
     * @Rest\View()
     * @OA\Get(
     *     tags={"Card"},
     *     summary="Get details card's",
     *     path="/sales/cardList/{username}",
     *     security={{"bearerAuth":{}}},
     *     operationId="username",
     *     @OA\Parameter(
     *          parameter="username",
     *          name="username",
     *          in="path",
     *          description="Username to get details",
     *          required=true,
     *          @OA\Schema(
     *              type="string"
     *          )
     *     ),
     *     @OA\Response(
     *          response="404",
     *          description="User not found or Product Sale not found",
     *          @OA\JsonContent(ref="#/components/schemas/ApiErrorResponseDTO")
     *     ),
     *     @OA\Response(
     *          response="200",
     *          description="Return an array of product sale",
     *          @OA\JsonContent(ref="#/components/schemas/ProductSaleDTO")
     *     )
     * )
     * @param Request $request
     * @return array
     */
    public function getCardDetailAction(Request $request)
    {
        try {
            $beSale = $this->saleService->gatCardDetail($request->get('username'));
            return DataManipulation::arrayMap(ProductSaleDTO::class,$beSale);
        }
        catch (Exception $exception)
        {
            throw new HttpException($exception->getCode(),$exception->getMessage());
        }
    }

    /**
     * @Rest\Get(path="/api/sales/confirmCard/{username}/{payementId}")
     * @Rest\View()
     * @OA\Get(
     *     tags={"Card"},
     *     summary="Confirm card",
     *     path="/sales/confirmCard/{username}/{payementId}",
     *     security={{"bearerAuth":{}}},
     *     operationId="username, payementId",
     *     @OA\Parameter(
     *          parameter="username",
     *          name="username",
     *          in="path",
     *          description="Username to get the card",
     *          required=true,
     *          @OA\Schema(
     *              type="string"
     *          )
     *     ),
     *     @OA\Parameter(
     *          parameter="payementId",
     *          name="payementId",
     *          in="path",
     *          description="Payement id of pay pal",
     *          required=true,
     *          @OA\Schema(
     *              type="integer"
     *          )
     *     ),
     *     @OA\Response(
     *          response="500",
     *          description="Unexpected Error",
     *          @OA\JsonContent(ref="#/components/schemas/ApiErrorResponseDTO")
     *     ),
     *     @OA\Response(
     *          response="404",
     *          description="Payement not found or User not found",
     *          @OA\JsonContent(ref="#/components/schemas/ApiErrorResponseDTO")
     *     ),
     *     @OA\Response(
     *          response="200",
     *          description="Return an boolean"
     *     )
     * )
     * @param Request $request
     * @return bool
     * @throws \Exception
     */
    public function confirmCardAction(Request $request)
    {
        try {
            return $this->saleService->confirmCard($request->get('username'),$request->get('payementId'));
        }
        catch (Exception $exception)
        {
            throw new Exception($exception->getCode(),$exception->getMessage());
        }

    }

    /**
     * @Rest\Get(path="/api/sales/summaryOrder/{username}")
     * @Rest\View()
     * @OA\Get(
     *     tags={"Card"},
     *     summary="Summary Order",
     *     path="/sales/summaryOrder/{username}",
     *     security={{"bearerAuth":{}}},
     *     operationId="username",
     *     @OA\Parameter(
     *          parameter="username",
     *          name="username",
     *          in="path",
     *          description="Username to get the card",
     *          required=true,
     *          @OA\Schema(
     *              type="string"
     *          )
     *     ),
     *     @OA\Response(
     *          response="404",
     *          description="No found product sale",
     *          @OA\JsonContent(ref="#/components/schemas/ApiErrorResponseDTO")
     *     ),
     *     @OA\Response(
     *          response="200",
     *          description="Return an array of sale",
     *          @OA\JsonContent(ref="#/components/schemas/SummaryOfProductSaleDTO")
     *     )
     * )
     * @param Request $request
     * @return array
     */
    public function getSummaryOrderAction(Request $request)
    {
        try {
            $summaryOrder = $this->saleService->getSummaryOrder($request->get('username'));
            return DataManipulation::arrayMap(SummaryOfProductSaleDTO::class,$summaryOrder);
        }
        catch (Exception $exception)
        {
            throw new Exception($exception->getCode(),$exception->getMessage());
        }
    }

    /**
     * @Rest\Delete(path="/api/sales/removeProduct/{username}/{productSale}")
     * @Rest\View()
     * @OA\Get(
     *     tags={"Card"},
     *     summary="Remove product",
     *     path="/sales/summaryOrder/{username}/{productSale}",
     *     security={{"bearerAuth":{}}},
     *     operationId="username,productSale",
     *     @OA\Parameter(
     *          parameter="username",
     *          name="username",
     *          in="path",
     *          description="Username to get card",
     *          required=true,
     *          @OA\Schema(
     *              type="string"
     *          )
     *     ),
     *     @OA\Parameter(
     *          parameter="productSale",
     *          name="productSale",
     *          in="path",
     *          description="ProductSale to get product sale",
     *          required=true,
     *          @OA\Schema(
     *              type="integer"
     *          )
     *     ),
     *     @OA\Response(
     *          response="500",
     *          description="Unexpected Error",
     *          @OA\JsonContent(ref="#/components/schemas/ApiErrorResponseDTO")
     *     ),
     *     @OA\Response(
     *          response="404",
     *          description="No found product on card",
     *          @OA\JsonContent(ref="#/components/schemas/ApiErrorResponseDTO")
     *     ),
     *     @OA\Response(
     *          response="200",
     *          description="Return a card detail",
     *          @OA\JsonContent(ref="#/components/schemas/ProductSaleDTO")
     *     )
     * )
     * @param Request $request
     * @return array
     */
    public function removeProductFromCardAction(Request $request)
    {
        try {
                $beSale = $this->saleService->removeProductFromCard($request->get('productSale'),$request->get('username'));
                return DataManipulation::arrayMap(ProductSaleDTO::class,$beSale);
        }
        catch (Exception $exception)
        {
            throw new HttpException($exception->getCode(),$exception->getMessage());
        }

    }
}
