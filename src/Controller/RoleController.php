<?php


namespace App\Controller;


use App\Form\RoleFormAddType;
use App\Form\RoleType;
use App\Models\Forms\RoleForm;
use App\Models\Forms\RoleFormAdd;
use App\Services\RoleService;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;

class RoleController extends AbstractFOSRestController
{
    /**
     * @var RoleService $roleService
     */
    private RoleService $roleService;

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

    /**
     * @param Request $request
     * @Rest\Post(path="api/role/addRole")
     * @Rest\View()
     * @IsGranted("ROLE_ADMIN")
     * @return RoleFormAdd
     */
    public function addNewRoleAction(Request $request)
    {
        $roleFormAdd = new RoleFormAdd();
        $data = json_decode($request->getContent(), true);
        $form = $this->createForm(RoleFormAddType::class, $roleFormAdd, [
            'csrf_protection' => false
        ]);
        $form->handleRequest($request);
        $form->submit($data);
        if ($form->isSubmitted() && $form->isValid())
        {
            return $this->roleService->addNewRole($form->getData());
        }
        return $roleFormAdd;
    }
}
