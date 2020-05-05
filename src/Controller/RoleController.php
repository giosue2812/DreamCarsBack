<?php


namespace App\Controller;


use App\Services\RoleService;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class RoleController extends AbstractFOSRestController
{
    /**
     * @var RoleService $roleService
     */
    private $roleService;

    /**
     * RoleController constructor.
     * @param RoleService $roleService
     */
    public function __construct(RoleService $roleService)
    {
        $this->roleService = $roleService;
    }

    /**
     * @Rest\Get(path="api/roles")
     * @Rest\View()
     * @IsGranted("ROLE_ADMIN")
     */
    public function getRolesAction()
    {
        return $this->roleService->getRoles();
    }
}
