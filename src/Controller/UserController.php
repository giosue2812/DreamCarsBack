<?php

namespace App\Controller;

use App\DTO\JsonResponseDTO;
use App\Form\GroupeType;
use App\Form\RoleType;
use App\Form\UserType;
use App\Form\UserUpdateType;
use App\Models\Forms\GroupeForm;
use App\Models\Forms\RoleForm;
use App\Models\Forms\UserForm;
use App\Models\Forms\UserFormUpdate;
use App\Services\UserService;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;


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
     * @param Request $request
     * @return mixed
     */
    public function createAction(Request $request)
    {
        $userForm = new UserForm();
        /**
         * Use Json_decode to deserialize the content
         */
        $data = json_decode($request->getContent(),true);
        $form = $this->createForm(UserType::class,$userForm,[
            /**
             * We don't need the protection. Because Angular is in charge of this
             */
            'csrf_protection' => false
        ]);
        $form->handleRequest($request);
        $form->submit($data);
        if($form->isSubmitted() && $form->isValid())
        {
            /**
             * I call service users
             */
            $this->userService->create($form->getData());
        }
        return $userForm;
//        return new Response('Creation Success',Response::HTTP_OK,['content-type'=>'application/json']);
    }

    /**
     * @param Request $request
     * @Rest\Get(path="/api/user/{username}")
     * @Rest\View()
     * @return JsonResponseDTO
     */
    public function userAction(Request $request)
    {
        $user = $this->userService->getUserByUserName($request->get('username'));
        return new JsonResponseDTO('200','Success',$user);
    }

    /**
     * @param Request $request
     * @Rest\Put(path="/api/user/update/{id}")
     * @Rest\View()
     * @return mixed
     */
    public function userUpdateAction(Request $request)
    {
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
            $this->userService->update($form->getData(),$request->get('id'));
        }
        return $userFormUpdate;
//        return new Response('Update Success',Response::HTTP_OK,['content-type'=>'application/json']);
    }

    /**
     * @Rest\Get(path="/api/user/search/{user}")
     * @Rest\View()
     * @param Request $request
     * @return array
     */
    public function searchUserAction(Request $request)
    {
        return $this->userService->searchUser($request->get('user'));
    }

    /**
     * @Rest\Put(path="/api/user/addGroupe/{userId}")
     * @Rest\View()
     * @param Request $request
     * @return JsonResponseDTO
     */
    public function addGroupeAction(Request $request)
    {
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
            $addGroupe = $this->userService->addGroupe($request->get('userId'),$form->getData());
        }
        return $addGroupe;
    }

    /**
     * @param Request $request
     * @Rest\Put(path="/api/user/addRole/{userId}")
     * @Rest\View()
     * @return JsonResponseDTO
     * @throws \Exception
     */
    public function addRoleAction(Request $request){
        $addRole = "";
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
            $addRole = $this->userService->addRole($request->get('userId'),$form->getData());
        }
        return $addRole;
    }

    /**
     * @param Request $request
     * @Rest\Delete(path="/api/user/removeGroupe/{userId}/{groupe}")
     * @Rest\View()
     * @return JsonResponseDTO
     */
    public function removeGroupeAction(Request $request)
    {
        return $this->userService->removeGroupe($request->get('userId'),$request->get('groupe'));
    }

    /**
     * @param Request $request
     * @Rest\Delete(path="/api/user/updateUserRole/{userId}/{roleId}")
     * @Rest\View()
     * @return mixed
     */
    public function removeRoleUserAction(Request $request){
        return $this->userService->removeUserRole($request->get('userId'),$request->get('roleId'));
    }
}
