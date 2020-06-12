<?php


namespace App\Controller;


use App\DTO\CategoriesChoiceDTO;
use App\Form\CategoryType;
use App\Models\Forms\CategoryForm;
use App\Services\CategoryService;
use App\Utils\DataManipulation;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;
use OpenApi\Annotations as OA;
use Symfony\Component\VarDumper\Cloner\Data;

class CategoriesController extends AbstractFOSRestController
{
    /**
     * @var CategoryService $service
     */
    private $service;

    public function __construct(CategoryService $service)
    {
        $this->service = $service;
    }

    /**
     * @Rest\Get(path="/api/categories")
     * @Rest\View()
     * @OA\Get(
     *     tags={"Category"},
     *     path="/categories",
     *     security={{"bearerAuth":{}}},
     *     summary="Get a list of category",
     *     operationId="category",
     *     @OA\Response(
     *          response="404",
     *          description="No found category",
     *          @OA\JsonContent(ref="#/components/schemas/ApiErrorResponseDTO")
     *     ),
     *     @OA\Response(
     *          response="200",
     *          description="Return a list of category",
     *          @OA\JsonContent(ref="#/components/schemas/CategoriesChoiceDTO")
     *     )
     * )
     * @return array
     */
    public function getCategoriesListAction()
    {
        try {
            $categories = $this->service->getCategoriesList();
            return DataManipulation::arrayMap(CategoriesChoiceDTO::class,$categories);
        }
        catch (\Exception $exception)
        {
            throw new HttpException($exception->getCode(),$exception->getMessage());
        }
    }

    /**
     * @Rest\Get(path="/api/category/{categoryId}")
     * @Rest\View()
     * @OA\Get(
     *     tags={"Category"},
     *     path="/category/{categoryId}",
     *     security={{"bearerAuth":{}}},
     *     summary="Get a category",
     *     operationId="category",
     *     @OA\Parameter(
     *          description="Id of category",
     *          in="path",
     *          name="categoryId",
     *          required=true,
     *          @OA\Schema(
     *              type="integer",
     *              format="int64"
     *          )
     *     ),
     *     @OA\Response(
     *          response="404",
     *          description="Category not found",
     *          @OA\JsonContent(ref="#/components/schemas/ApiErrorResponseDTO")
     *     ),
     *     @OA\Response(
     *          response="200",
     *          description="Return a category",
     *          @OA\JsonContent(ref="#/components/schemas/CategoriesChoiceDTO")
     *     )
     * )
     * @param Request $request
     * @return array
     */
    public function getCategoryIdAction(Request $request)
    {
        try {
            $category = $this->service->getCategoryId($request->get('categoryId'));
            return DataManipulation::arrayMap(CategoriesChoiceDTO::class,$category);
        }
        catch (Exception $exception)
        {
            throw new HttpException($exception->getCode(),$exception->getMessage());
        }
    }

    /**
     * @Rest\Put(path="/api/category/edit/{categoryId}")
     * @Rest\View()
     * @OA\Put(
     *     tags={"Category"},
     *     path="/category/edit/{categoryId}",
     *     security={{"bearerAuth":{}}},
     *     summary="Edit category",
     *     @OA\RequestBody(
     *          required=true,
     *          description="Update Category",
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  ref="#/components/schemas/CategoryForm"
     *              )
     *          )
     *     ),
     *     @OA\Parameter(
     *          parameter="categoryId",
     *          name="categoryId",
     *          in="path",
     *          description="Id of category to update",
     *          required=true,
     *          @OA\Schema(
     *              type="integer"
     *          )
     *     ),
     *     @OA\Response(
     *          response="400",
     *          description="Form is invalid",
     *          @OA\JsonContent(ref="#/components/schemas/ApiErrorResponseDTO")
     *     ),
     *     @OA\Response(
     *          response="404",
     *          description="Category not found or Category already exist",
     *          @OA\JsonContent(ref="#/components/schemas/ApiErrorResponseDTO")
     *     ),
     *     @OA\Response(
     *          response="500",
     *          description="Unexpected Error",
     *          @OA\JsonContent(ref="#/components/schemas/ApiErrorResponseDTO")
     *     ),
     *     @OA\Response(
     *          response="200",
     *          description="Return a array of category",
     *          @OA\JsonContent(ref="#/components/schemas/CategoriesChoiceDTO")
     *     )
     * )
     * @param Request $request
     * @return array
     * @throws \Exception
     */
    public function editCategoryAction(Request $request)
    {
        try {
            $categoryForm = new CategoryForm();
            $data = json_decode($request->getContent(), true);
            $form = $this->createForm(CategoryType::class, $categoryForm, [
                'csrf_protection' => false
            ]);
            $form->handleRequest($request);
            $form->submit($data);
            if ($form->isSubmitted() && $form->isValid()) {
                $category = $this->service->editCategory($form->getData(),$request->get('categoryId'));
                return DataManipulation::arrayMap(CategoriesChoiceDTO::class,$category);
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
     * @Rest\Delete(path="/api/category/remove/{categoryId}")
     * @Rest\View()
     * @OA\Delete(
     *     tags={"Category"},
     *     path="/category/remove/{categoryId}",
     *     security={{"bearerAuth":{}}},
     *     summary="Delete on category",
     *     operationId="categoryId",
     *     @OA\Parameter(
     *          name="categoryId",
     *          in="path",
     *          description="Id of category to remove",
     *          required=true,
     *          @OA\Schema(
     *              type="integer"
     *          )
     *     ),
     *     @OA\Response(
     *          response="404",
     *          description="Category not found",
     *          @OA\JsonContent(ref="#/components/schemas/ApiErrorResponseDTO")
     *     ),
     *     @OA\Response(
     *          response="500",
     *          description="Unexpected Error",
     *          @OA\JsonContent(ref="#/components/schemas/ApiErrorResponseDTO")
     *     ),
     *     @OA\Response(
     *          response="200",
     *          description="Return an array of category",
     *          @OA\JsonContent(ref="#/components/schemas/CategoriesChoiceDTO")
     *     )
     * )
     * @param Request $request
     * @return array
     * @throws \Exception
     */
    public function removeCategoryAction(Request $request)
    {
        try {
            $category = $this->service->removeCategory($request->get('categoryId'));
            return DataManipulation::arrayMap(CategoriesChoiceDTO::class,$category);
        }
        catch (Exception $exception)
        {
            throw new HttpException($exception->getCode(),$exception->getMessage());
        }
    }
}
