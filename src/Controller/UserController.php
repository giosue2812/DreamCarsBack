<?php

namespace App\Controller;

use App\DTO\JsonResponseDTO;
use App\DTO\UserDetailsDTO;
use App\DTO\UserRoleDetailsDTO;
use App\Entity\User;
use App\Form\GroupeType;
use App\Form\RoleType;
use App\Form\UserType;
use App\Form\UserUpdateType;
use App\Models\Forms\GroupeForm;
use App\Models\Forms\RoleForm;
use App\Models\Forms\UserForm;
use App\Models\Forms\UserFormUpdate;
use App\Services\UserService;
use App\Utils\DataManipulation;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;
use OpenApi\Annotations as OA;

class UserController extends AbstractFOSRestController
{
    /**
     * @var UserService $userService
     */
    private UserService $userService;

    /**
     * UserController constructor.
     * @param UserService $userService
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * @Rest\Post(path="/api/create")
     * @Rest\View()
     * @OA\Post(
     *     tags={"User"},
     *     path="/create",
     *     summary="Add new User",
     *     @OA\RequestBody(
     *          description="Create new User",
     *          required=true,
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  ref="#/components/schemas/UserForm"
     *              )
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
     *          description="Retur user created",
     *          @OA\JsonContent(ref="#/components/schemas/UserDetailsDTO")
     *     )
     * )
     * @param Request $request
     * @return mixed
     */
    public function createAction(Request $request)
    {
        try {
            $userForm = new UserForm();
            $data = json_decode($request->getContent(),true);
            $form = $this->createForm(UserType::class,$userForm,[
                'csrf_protection' => false
            ]);
            $form->handleRequest($request);
            $form->submit($data);
            if($form->isSubmitted() && $form->isValid())
            {
                /**
                 * I call service users
                 */
                $user = $this->userService->create($form->getData());
                return new UserDetailsDTO($user);
            }
            else
            {
                throw new Exception("Form is invalid",400);
            }
        }
        catch (\Exception $exception)
        {
            throw new HttpException($exception->getCode(), $exception->getMessage());
        }
    }

    /**
     * @param Request $request
     * @Rest\Get(path="/api/user/{username}")
     * @Rest\View()
     * @OA\Get(
     *     tags={"User"},
     *     summary="User",
     *     path="/user/{username}",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *          parameter="username",
     *          name="username",
     *          in="path",
     *          description="Email To find user profile",
     *          required=true,
     *          @OA\Schema(
     *              type="string"
     *          )
     *     ),
     *     @OA\Response(
     *          response="404",
     *          description="User not found",
     *          @OA\JsonContent(ref="#/components/schemas/ApiErrorResponseDTO")
     *     ),
     *     @OA\Response(
     *          response="200",
     *          description="Return user",
     *          @OA\JsonContent(ref="#/components/schemas/UserDetailsDTO")
     *     )
     * )
     * @return UserDetailsDTO
     */
    public function userAction(Request $request)
    {
        try {
            $user = $this->userService->getUserByUserName($request->get('username'));
            return new UserDetailsDTO($user);
        }
        catch (Exception $exception)
        {
            throw new HttpException($exception->getCode(), $exception->getMessage());
        }

    }

    /**
     * @Rest\Get(path="api/userID/{id}")
     * @Rest\View()
     * @OA\Get(
     *     tags={"User"},
     *     path="/userID/{id}",
     *     security={{"bearerAuth":{}}},
     *     summary="Find user by id",
     *     @OA\Parameter(
     *          parameter="id",
     *          name="id",
     *          in="path",
     *          description="Id to found user",
     *          required=true,
     *          @OA\Schema(
     *              type="integer"
     *          )
     *     ),
     *     @OA\Response(
     *          response="404",
     *          description="User not found",
     *          @OA\JsonContent(ref="#/components/schemas/ApiErrorResponseDTO")
     *     ),
     *     @OA\Response(
     *          response="200",
     *          description="Return user",
     *          @OA\JsonContent(ref="#/components/schemas/UserDetailsDTO")
     *     )
     * )
     * @param Request $request
     * @return UserDetailsDTO
     */
    public function userById(Request $request)
    {
        try {
            $user = $this->userService->getUser($request->get('id'));
            return new UserDetailsDTO($user);
        }
        catch (Exception $exception)
        {
            throw new HttpException($exception->getCode(),$exception->getMessage());
        }

    }

    /**
     * @param Request $request
     * @Rest\Put(path="/api/user/update/{id}")
     * @OA\Put(
     *     tags={"User"},
     *     path="/user/update/{id}",
     *     security={{"bearerAuth":{}}},
     *     summary="Update User",
     *     operationId="update",
     *     @OA\RequestBody(
     *          required=true,
     *          description="Update user",
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  ref="#/components/schemas/UserFormUpdate"
     *              )
     *          )
     *     ),
     *     @OA\Parameter(
     *          parameter="id",
     *          name="id",
     *          in="path",
     *          description="Id of user to be update",
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
     *          description="User not found",
     *          @OA\JsonContent(ref="#/components/schemas/ApiErrorResponseDTO")
     *     ),
     *     @OA\Response(
     *          response="500",
     *          description="Unexpected Error",
     *          @OA\JsonContent(ref="#/components/schemas/ApiErrorResponseDTO")
     *     ),
     *     @OA\Response(
     *          response="200",
     *          description="User is updated",
     *          @OA\JsonContent(ref="#/components/schemas/UserDetailsDTO")
     *     )
     * )
     * @Rest\View()
     * @return UserDetailsDTO
     */
    public function userUpdateAction(Request $request)
    {
        try {
            $userFormUpdate = new UserFormUpdate();
            /**
             * Use Json_decode to deserialize the content
             */
            $data = json_decode($request->getContent(),true);
            $form = $this->createForm(UserUpdateType::class,$userFormUpdate,[
                'csrf_protection' => false
            ]);
            $form->handleRequest($request);
            $form->submit($data);
            if($form->isSubmitted() && $form->isValid())
            {
                /**
                 * I call service users
                 */
                $user = $this->userService->update($form->getData(),$request->get('id'));
                return new UserDetailsDTO($user);
            }
            else
            {
                throw new Exception('Form is invalid',400);
            }
        }
        catch (\Exception $exception)
        {
            throw new HttpException($exception->getCode(),$exception->getMessage());
        }
    }

    /**
     * @Rest\Get(path="/api/user/search/{keyWord}")
     * @Rest\View()
     * @OA\Get(
     *     tags={"User"},
     *     summary="Search user",
     *     path="/user/search/{keyWord}",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *          parameter="keyWord",
     *          name="keyWord",
     *          in="path",
     *          description="keyWord to find user profile",
     *          required=true,
     *          @OA\Schema(
     *              type="string"
     *          )
     *     ),
     *     @OA\Response(
     *          response="404",
     *          description="User not found",
     *          @OA\JsonContent(ref="#/components/schemas/ApiErrorResponseDTO")
     *     ),
     *     @OA\Response(
     *          response="200",
     *          description="Return User",
     *          @OA\JsonContent(ref="#/components/schemas/UserDetailsDTO")
     *     )
     * )
     * @param Request $request
     * @return array
     */
    public function searchUserAction(Request $request)
    {
        try {
            $user = $this->userService->searchUser($request->get('keyWord'));
            return DataManipulation::arrayMap(UserDetailsDTO::class,$user);
        }
        catch (Exception $exception)
        {
            throw new HttpException($exception->getCode(),$exception->getMessage());
        }
    }

    /**
     * @Rest\Put(path="/api/user/addGroupe/{userId}")
     * @Rest\View()
     * @OA\Put(
     *     tags={"User"},
     *     path="/user/addGroupe/{userId}",
     *     summary="Add Groupe to an user",
     *     security={{"bearerAuth":{}}},
     *     operationId="addGroupe",
     *     @OA\RequestBody(
     *          required=true,
     *          description="Add groupe for user",
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  ref="#/components/schemas/GroupeForm"
     *              )
     *          )
     *     ),
     *     @OA\Parameter(
     *          parameter="userId",
     *          name="userId",
     *          in="path",
     *          description="Id of user to add groupe",
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
     *          description="User or groupe not found",
     *          @OA\JsonContent(ref="#/components/schemas/ApiErrorResponseDTO")
     *     ),
     *     @OA\Response(
     *          response="500",
     *          description="Unexpected Error",
     *          @OA\JsonContent(ref="#/components/schemas/ApiErrorResponseDTO")
     *     ),
     *     @OA\Response(
     *          response="200",
     *          description="Groupe has been add for user",
     *          @OA\JsonContent(ref="#/components/schemas/UserDetailsDTO")
     *     )
     * )
     * @param Request $request
     * @return UserDetailsDTO
     */
    public function addGroupeAction(Request $request)
    {
        try {
            /**
             * Ne instance gor groupe form
             */
            $groupeForm = new GroupeForm();
            /**
             * Deserialization the request body
             */
            $data = json_decode($request->getContent(), true);
            /**
             * Creation form
             */
            $form = $this->createForm(GroupeType::class, $groupeForm, [
                'csrf_protection' => false
            ]);
            $form->handleRequest($request);
            $form->submit($data);
            if($form->isSubmitted() && $form->isValid())
            {
                /**
                 * we call the user service to add groupe
                 */
                $user = $this->userService->addGroupe($request->get('userId'),$form->getData());
                return new UserDetailsDTO($user);
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
     * @param Request $request
     * @Rest\Put(path="/api/user/addRole/{userId}")
     * @Rest\View()
     * @OA\Put(
     *     tags={"User"},
     *     path="/user/addRole/{userId}",
     *     security={{"bearerAuth":{}}},
     *     summary="Add role for user",
     *     operationId="addRole",
     *     @OA\RequestBody(
     *          required=true,
     *          description="Add Role for user",
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  ref="#/components/schemas/RoleForm"
     *              )
     *          )
     *     ),
     *     @OA\Parameter(
     *          parameter="userId",
     *          name="userId",
     *          in="path",
     *          description="User id to add role",
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
     *          description="User or role not found",
     *          @OA\JsonContent(ref="#/components/schemas/ApiErrorResponseDTO")
     *     ),
     *     @OA\Response(
     *          response="500",
     *          description="Unexpected Error",
     *          @OA\JsonContent(ref="#/components/schemas/ApiErrorResponseDTO")
     *     ),
     *     @OA\Response(
     *          response="200",
     *          description="Role has been added",
     *          @OA\JsonContent(ref="#/components/schemas/UserRoleDetailsDTO")
     *     )
     * )
     * @return UserRoleDetailsDTO
     * @throws \Exception
     */
    public function addRoleAction(Request $request){
        try {
            /**
             * New instance to add the userRole
             */
            $roleForm = new RoleForm();
            /**
             * Deserialization the request body
             */
            $data = json_decode($request->getContent(),true);
            $form = $this->createForm(RoleType::class,$roleForm,[
                'csrf_protection'=>false
            ]);
            $form->handleRequest($request);
            $form->submit($data);
            if($form->isSubmitted() && $form->isValid())
            {
                /**
                 * we call the user service to add role
                 */
                $user = $this->userService->addRole($request->get('userId'),$form->getData());
                return new UserRoleDetailsDTO($user);
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
     * @param Request $request
     * @Rest\Delete(path="/api/user/removeGroupe/{userId}/{groupe}")
     * @Rest\View()
     * @return UserDetailsDTO
     */
    public function removeGroupeAction(Request $request)
    {
        try {
            $user = $this->userService->removeGroupe($request->get('userId'),$request->get('groupe'));
            return new UserDetailsDTO($user);
        }
        catch (Exception $exception)
        {
            throw new HttpException($exception->getCode(), $exception->getMessage());
        }
    }

    /**
     * @param Request $request
     * @Rest\Delete(path="/api/user/updateUserRole/{userRoleID}")
     * @Rest\View()
     * @return mixed
     * @throws \Exception
     */
    public function removeRoleUserAction(Request $request){
        return $this->userService->removeUserRole($request->get('userRoleID'));
    }
}
