<?php

namespace App\Controller;

use App\DTO\ProductDTO;
use App\Entity\Category;
use App\Form\CategoryType;
use App\Form\ProductType;
use App\Form\SearchType;
use App\Form\UploadFileType;
use App\Models\Forms\CategoryForm;
use App\Models\Forms\ProductForm;
use App\Models\Forms\ProductSearchForm;
use App\Models\Forms\UploadFileForm;
use App\Services\ProductService;
use App\Services\UploadService;
use App\Utils\DataManipulation;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;
use OpenApi\Annotations as OA;
use Symfony\Component\Validator\Constraints as Assert;
use function Symfony\Component\DependencyInjection\Loader\Configurator\ref;

class ProductController extends AbstractFOSRestController
{
    /**
     * @var ProductService $service
     */
    private $service;

    public function __construct(ProductService $service)
    {
        $this->service = $service;
    }

    /**
     * @Rest\Get(path="/api/product/list")
     * @Rest\View()
     * @OA\Get(
     *     tags={"Product"},
     *     summary="Array of product",
     *     path="/product/list",
     *     @OA\Response(
     *          response="404",
     *          description="Product no found in data base",
     *          @OA\JsonContent(ref="#/components/schemas/ApiErrorResponseDTO")
     *     ),
     *     @OA\Response(
     *          response="200",
     *          description="Return an array of product",
     *          @OA\JsonContent(ref="#/components/schemas/ProductDTO")
     *     )
     * )
     * @return array
     */
    public function productListAction()
    {
        try {
            $products = $this->service->productList();
            return DataManipulation::arrayMap(ProductDTO::class,$products);
        }
        catch (Exception $exception)
        {
            throw new HttpException($exception->getCode(), $exception->getMessage());
        }

    }

    /**
     * @Rest\Post(path="/api/product/create")
     * @Rest\View()
     * @OA\Post(
     *     tags={"Product"},
     *     path="/product/create",
     *     security={{"bearerAuth":{}}},
     *     summary="Add new product",
     *     @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(ref="#/components/schemas/ProductForm")
     *          )
     *     ),
     *     @OA\Response(
     *          response="400",
     *          description="Form is invalid",
     *          @OA\JsonContent(ref="#/components/schemas/ApiErrorResponseDTO")
     *     ),
     *     @OA\Response(
     *          response="500",
     *          description="Unexpected Error",
     *          @OA\JsonContent(ref="#/components/schemas/ApiErrorResponseDTO")
     *     ),
     *     @OA\Response(
     *          response="200",
     *          description="Return a array of new product",
     *          @OA\JsonContent(ref="#/components/schemas/ProductDTO")
     *     )
     * )
     * @param Request $request
     * @return array
     */
    public function productCreateAction(Request $request)
    {
        try {
            $productForm = new ProductForm();
            $data = json_decode($request->getContent(),true);
            $form = $this->createForm(ProductType::class,$productForm,[
                'csrf_protection'=>false
            ]);
            $form->handleRequest($request);
            $form->submit($data);
            if($form->isSubmitted() && $form->isValid())
            {
                $product = $this->service->createProduct($form->getData());
                return DataManipulation::arrayMap(ProductDTO::class,$product);
            }
            else
            {
                throw new Exception('Form is invalid',400);
            }
        }
        catch (Exception $exception)
        {
            throw new HttpException($exception->getCode(),$exception->getMessage());
        }
    }
    /**
     * @Rest\Put(path="/api/product/edit/{productId}")
     * @Rest\View()
     * @OA\Put(
     *     tags={"Product"},
     *     path="/product/edit/{productId}",
     *     security={{"bearerAuth":{}}},
     *     summary="Update Product",
     *     operationId="update",
     *     @OA\RequestBody(
     *          required=true,
     *          description="Update Product",
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  ref="#/components/schemas/ProductForm"
     *              )
     *          )
     *     ),
     *     @OA\Parameter(
     *          parameter="productId",
     *          name="productId",
     *          in="path",
     *          description="Id for the product to update",
     *          required=true,
     *          @OA\Schema(
     *              type="integer"
     *          )
     *     ),
     *     @OA\Response(
     *          response="500",
     *          description="Unexpected error",
     *          @OA\JsonContent(ref="#/components/schemas/ApiErrorResponseDTO")
     *     ),
     *     @OA\Response(
     *          response="400",
     *          description="Form is invalid",
     *          @OA\JsonContent(ref="#/components/schemas/ApiErrorResponseDTO")
     *     ),
     *     @OA\Response(
     *          response="404",
     *          description="Product not found or Supplier not found or category not found",
     *          @OA\JsonContent(ref="#/components/schemas/ApiErrorResponseDTO")
     *     ),
     *     @OA\Response(
     *          response="200",
     *          description="Return the product update",
     *          @OA\JsonContent(ref="#/components/schemas/ProductDTO")
     *     )
     * )
     * @param Request $request
     * @return array
     */
    public function productEditAction(Request $request)
    {
        $productForm = new ProductForm();
        $data = json_decode($request->getContent(),true);
        $form = $this->createForm(ProductType::class,$productForm,[
            'csrf_protection' => false
        ]);
        $form->submit($data);
        if($form->isSubmitted() && $form->isValid())
        {
            try {
                $products = $this->service->productEdit($request->get('productId'),$form->getData());
                return DataManipulation::arrayMap(ProductDTO::class,$products);
            }
            catch (\Exception $exception)
            {
                throw new HttpException($exception->getCode(),$exception->getMessage());
            }
        }
        else
        {
            throw new Exception('Form is invalid',400);
        }
    }

    /**
     * @param Request $request
     * @return array
     * @Rest\Get(path="/api/product/{productId}")
     * @Rest\View()
     * @OA\Get(
     *     tags={"Product"},
     *     path="/product/{productId}",
     *     security={{"bearerAuth":{}}},
     *     summary="Get a product",
     *     operationId="product",
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
     *     @OA\Response(
     *          response="404",
     *          description="Not found product",
     *          @OA\JsonContent(ref="#/components/schemas/ApiErrorResponseDTO")
     *     ),
     *     @OA\Response(
     *          response="200",
     *          description="Return an array of product",
     *          @OA\JsonContent(ref="#/components/schemas/ProductDTO")
     *     )
     * )
     */
    public function productAction(Request $request)
    {
        try {
            $product = $this->service->product($request->get('productId'));
            return DataManipulation::arrayMap(ProductDTO::class,$product);
        }
        catch (Exception $exception)
        {
            throw new HttpException($exception->getCode(),$exception->getMessage());
        }
    }

    /**
     * @Rest\Post(path="/api/product/search")
     * @Rest\View()
     * @OA\Post(
     *     tags={"Product"},
     *     path="/product/search",
     *     security={{"bearerAuth":{}}},
     *     summary="Product search",
     *     @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  ref="#/components/schemas/ProductSearchForm"
     *              )
     *          )
     *     ),
     *     @OA\Response(
     *          response="400",
     *          description="Form is invalid",
     *          @OA\JsonContent(ref="#/components/schemas/ApiErrorResponseDTO")
     *     ),
     *     @OA\Response(
     *          response="404",
     *          description="Product not found",
     *          @OA\JsonContent(ref="#/components/schemas/ApiErrorResponseDTO")
     *     ),
     *     @OA\Response(
     *          response="200",
     *          description="Return product",
     *          @OA\JsonContent(ref="#/components/schemas/ProductDTO")
     *     )
     * )
     * @param Request $request
     * @return array
     */
    public function productSearch(Request $request)
    {
        try {
            $productSearchForm = new  ProductSearchForm();
            $data = json_decode($request->getContent(), true);
            $form = $this->createForm(SearchType::class, $productSearchForm, [
                'csrf_protection' => false
            ]);
            $form->handleRequest($request);
            $form->submit($data);
            if ($form->isValid() && $form->isSubmitted()) {
                $product = $this->service->productSearch($form->getData());
                return DataManipulation::arrayMap(ProductDTO::class, $product);

            } else {
                throw new Exception('Form is invalid', 400);
            }
        }
        catch (Exception $exception)
        {
            throw new HttpException($exception->getCode(),$exception->getMessage());
        }
    }

    /**
     * @param Request $request
     * @return array
     * @Rest\Post(path="/api/product/uploadPicture/{productId}")
     * @Rest\View()
     * @OA\Post(
     *     tags={"Product"},
     *     path="/product/uploadPicture/{productId}",
     *     security={{"bearerAuth":{}}},
     *     summary="Picture upload",
     *     @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="multipart/form-data",
     *              @OA\Schema(
     *                  @OA\Property(
     *                      description="Picture to upload",
     *                      property="picture",
     *                      type="file",
     *                      format="file"
     *                  ),
     *                      required={"file"}
     *              )
     *          )
     *     ),
     *     @OA\Parameter(
     *          description="Id of the product",
     *          in="path",
     *          name="productId",
     *          required=true,
     *          @OA\Schema(
     *              type="integer",
     *              format="int64"
     *          )
     *     ),
     *     @OA\Response(
     *          response="500",
     *          description="Unexpected Error",
     *          @OA\JsonContent(ref="#/components/schemas/ApiErrorResponseDTO")
     *     ),
     *     @OA\Response(
     *          response="404",
     *          description="Picture not found or Image not found",
     *          @OA\JsonContent(ref="#/components/schemas/ApiErrorResponseDTO")
     *     ),
     *     @OA\Response(
     *          response="200",
     *          description="Return arry product",
     *          @OA\JsonContent(ref="#/components/schemas/ProductDTO")
     *     )
     * )
     */
    public function uploadPictureAction(Request $request)
    {
        try {
                $product = $this->service->uploadPicture($request->files->get('picture'),$request->get('productId'));
                return DataManipulation::arrayMap(ProductDTO::class,$product);
        }
        catch (Exception $exception)
        {
            throw new HttpException($exception->getCode(),$exception->getMessage());
        }
    }

    /**
     * @Rest\Delete(path="/api/product/remove/{productId}")
     * @Rest\View()
     * @OA\Delete(
     *     tags={"Product"},
     *     path="product/remove/{productId}",
     *     summary="Remove product",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *          description="Id of product to remove",
     *          in="path",
     *          name="productId",
     *          required=true,
     *          @OA\Schema(
     *              type="integer",
     *              format="int64"
     *          )
     *     ),
     *     @OA\Response(
     *          response="500",
     *          description="Unexpected Error",
     *          @OA\JsonContent(ref="#/components/schemas/ApiErrorResponseDTO")
     *     ),
     *     @OA\Response(
     *          response="404",
     *          description="Product not found",
     *          @OA\JsonContent(ref="#/components/schemas/ApiErrorResponseDTO")
     *     ),
     *     @OA\Response(
     *          response="200",
     *          description="Return array product",
     *          @OA\JsonContent(ref="#/components/schemas/ProductDTO")
     *     )
     * )
     * @param Request $request
     * @return array
     * @throws \Exception
     */
    public function removeProductAction(Request $request)
    {
        try {
            $product = $this->service->removeProduct($request->get('productId'));
            return DataManipulation::arrayMap(ProductDTO::class,$product);
        }
        catch (Exception $exception)
        {
            throw new HttpException($exception->getCode(),$exception->getMessage());
        }
    }
}
