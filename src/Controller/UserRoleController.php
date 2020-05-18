<?php


namespace App\Controller;


use App\DTO\JsonResponseDTO;
use App\Services\UserRoleService;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\JsonResponse;

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
     * @return JsonResponseDTO
     */
    public function getUserRoleAction()
    {
        return $this->userRoleService->getUserRole();
    }
}
