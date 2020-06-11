<?php


namespace App\Controller;


use App\DTO\CategoriesChoiceDTO;
use App\Services\CategoryService;
use App\Utils\DataManipulation;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;
use OpenApi\Annotations as OA;

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
     *     summary="Get a lisr of category",
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
}
