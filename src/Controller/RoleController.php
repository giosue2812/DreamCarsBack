<?php


namespace App\Controller;


use App\DTO\JsonResponseDTO;
use App\DTO\RoleDetailsDTO;
use App\Entity\Role;
use App\Form\RoleFormAddType;
use App\Models\Forms\RoleFormAdd;
use App\Services\RoleService;
use App\Utils\DataManipulation;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;
use OpenApi\Annotations as OA;

/**
 * Class RoleController
 * @package App\Controller
 * @OA\SecurityScheme(bearerFormat="JWT",type="http",securityScheme="bearerAuth",scheme="bearer")
 */
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
     *
     * @OA\Get(
     *     tags={"Roles"},
     *     summary="Array of roles",
     *     path="/roles",
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *          response="404",
     *          description="Roles no found in data-base",
     *          @OA\JsonContent(ref="#/components/schemas/ApiErrorResponseDTO")
     * ),
     *     @OA\Response(
     *          response="200",
     *          description="Return an array roles",
     *          @OA\JsonContent(ref="#/components/schemas/RoleDetailsDTO")
     *  )
     * )
     */
    public function getRolesAction()
    {
        try {
            //Get roles from service
            $roles = $this->roleService->getRoles();
            //Use utilis to manipulation of data
            //return RoleDetailsDTO
            return DataManipulation::arrayMap(RoleDetailsDTO::class,$roles);
            //In case of error
        }
        catch (\Exception $exception)
        {
            throw new HttpException(404,$exception->getMessage());
        }
    }

    /**
     * @param Request $request
     * @Rest\Post(path="api/role/addRole")
     * @Rest\View()
     * @IsGranted("ROLE_ADMIN")
     * @OA\Post(
     *     tags={"Roles"},
     *     path="/role/addRole",
     *     security={{"bearerAuth":{}}},
     *     summary="Add new role",
     *     @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  @OA\Property(
     *                      property="role",
     *                      type="string"
     *                  )
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
     *          description="Role exist",
     *          @OA\JsonContent(ref="#/components/schemas/ApiErrorResponseDTO")
     *     ),
     *     @OA\Response(
     *          response="500",
     *          description="Unexpected Error",
     *          @OA\JsonContent(ref="#/components/schemas/ApiErrorResponseDTO")
     *     ),
     *     @OA\Response(
     *          response="200",
     *          description="Return an array role",
     *          @OA\JsonContent(ref="#/components/schemas/RoleDetailsDTO")
     *     )
     * )
     * @return array
     * @throws \Exception
     */
    public function addNewRoleAction(Request $request)
    {
        try {
            //New roleForm
            $roleFormAdd = new RoleFormAdd();
            //Deserialization of body content
            $data = json_decode($request->getContent(), true);
            //Form tp add new role in the data base
            $form = $this->createForm(RoleFormAddType::class, $roleFormAdd, [
                'csrf_protection' => false
            ]);
            $form->handleRequest($request);
            $form->submit($data) ;
            //test if the form is valid or not
            if ($form->isSubmitted() && $form->isValid())
            {
                //call role service to add new role
                $role = $this->roleService->addNewRole($form->getData());
                //Array role is returned. ArrayMap to create a new Response DTO
                return DataManipulation::arrayMap(RoleDetailsDTO::class,$role);
            }
            else
            {
                //Is the form is not valid. Message error.
                throw new \Exception('Form is invalid',400);
            }
        } catch (\Exception $exception)
        {
            //In case no form valid we send a error
            throw new HttpException($exception->getCode(), $exception->getMessage());
        }
    }

    /**
     * @Rest\Put(path="api/role/updateRole/{idRole}")
     * @Rest\View()
     * @IsGranted("ROLE_ADMIN")
     * @OA\Put(
     *     tags={"Roles"},
     *     path="/role/updateRole/{idRole}",
     *     security={{"bearerAuth":{}}},
     *     summary="Update role",
     *     operationId="updateRole",
     *     @OA\RequestBody(
     *          required=true,
     *          description="Update role name",
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  @OA\Property(
     *                      property="role",
     *                      type="string",
     *                  )
     *              )
     *          )
     *     ),
     *     @OA\Parameter(
     *          parameter="idRole",
     *          name="idRole",
     *          in="path",
     *          description="Id of role to be update",
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
     *          description="Role not found",
     *          @OA\JsonContent(ref="#/components/schemas/ApiErrorResponseDTO")
     *     ),
     *     @OA\Response(
     *          response="500",
     *          description="Unexpected Error",
     *          @OA\JsonContent(ref="#/components/schemas/ApiErrorResponseDTO")
     *     ),
     *     @OA\Response(
     *          response="200",
     *          description="Role is updated",
     *          @OA\JsonContent(ref="#/components/schemas/RoleDetailsDTO")
     *     )
     * )
     * @param Request $request
     * @return array
     * @throws \Exception
     */
    public function updateRoleAction(Request $request)
    {
        try {
            $roleFormUpdate = new RoleFormAdd();
            $data = json_decode($request->getContent(),true);
            $form = $this->createForm(RoleFormAddType::class, $roleFormUpdate,[
                'csrf_protection' => false
            ]);
            $form->handleRequest($request);
            $form->submit($data);

            if($form->isSubmitted() && $form->isValid())
            {
                $role = $this->roleService->updateRole($request->get('idRole'),$form->getData());
                return DataManipulation::arrayMap(RoleDetailsDTO::class,$role);
            }
            else{
                throw new \Exception('Form is invalid',400);
            }
        }
        catch (\Exception $exception)
        {
            throw new HttpException($exception->getCode(),$exception->getMessage());
        }
    }

    /**
     * @Rest\Delete(path="api/role/removeRole/{idRole}")
     * @Rest\View()
     * @OA\Delete(
     *     tags={"Roles"},
     *     path="/role/removeRole/{idRole}",
     *     security={{"bearerAuth":{}}},
     *     summary="Delete one role",
     *     operationId="removeRole",
     *     @OA\Parameter(
     *          name="idRole",
     *          in="path",
     *          description="Id of role to be remove",
     *          required=true,
     *          @OA\Schema(
     *              type="integer"
     *          )
     *     ),
     *     @OA\Response(
     *          response="404",
     *          description="Role not found",
     *          @OA\JsonContent(ref="#/components/schemas/ApiErrorResponseDTO")
     *     ),
     *     @OA\Response(
     *          response="500",
     *          description="Unexpected error",
     *          @OA\JsonContent(ref="#/components/schemas/ApiErrorResponseDTO")
     *     ),
     *     @OA\Response(
     *          response="200",
     *          description="Role is removed",
     *          @OA\JsonContent(ref="#/components/schemas/RoleDetailsDTO")
     *     ),
     * )
     * @param Request $request
     * @return Role[]
     * @throws \Exception
     */
    public function removeRole(Request $request)
    {
        try {
            $roles = $this->roleService->removeRole($request->get('idRole'));
           return DataManipulation::arrayMap(RoleDetailsDTO::class,$roles);
        }
        catch (\Exception $exception)
        {
            throw new HttpException($exception->getCode(),$exception->getMessage());
        }

    }
}
