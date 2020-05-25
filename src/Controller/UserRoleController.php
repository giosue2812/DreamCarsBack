<?php


namespace App\Controller;


use App\DTO\JsonResponseDTO;
use App\DTO\UserRoleDetailsDTO;
use App\Entity\UserRole;
use App\Services\UserRoleService;
use App\Utils\DataManipulation;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\HttpException;
use OpenApi\Annotations as OA;
class UserRoleController extends AbstractFOSRestController
{
    /**
     * @var UserRoleService $userRoleService
     */
    private $userRoleService;

    /**
     * UserRoleConstroller constructor.
     * @param UserRoleService $userRoleService
     */
    public function __construct(UserRoleService $userRoleService)
    {
        $this->userRoleService = $userRoleService;
    }

    /**
     * @Rest\Get(path="api/userRole")
     * @Rest\View()
     * @OA\Get(
     *     tags={"UserRoles"},
     *     summary="Get UserRoles",
     *     path="/userRole",
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *          response="404",
     *          description="UserRole not found",
     *          @OA\JsonContent(ref="#/components/schemas/ApiErrorResponseDTO")
     *     ),
     *     @OA\Response(
     *          response="200",
     *          description="UserRoles",
     *          @OA\JsonContent(ref="#/components/schemas/UserRoleDetailsDTO")
     *     )
     * )
     * @return UserRole[]
     */
    public function getUserRoleAction()
    {
        try {
            $userRole = $this->userRoleService->getUserRole();
            return DataManipulation::arrayMap(UserRoleDetailsDTO::class,$userRole);
        }
        catch (Exception $exception)
        {
            throw new HttpException($exception->getCode(),$exception->getMessage());
        }

    }
}
