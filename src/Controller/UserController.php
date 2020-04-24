<?php

namespace App\Controller;

use App\DTO\UserDetailsDTO;
use App\Form\UserType;
use App\Form\UserUpdateType;
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
    private $userService;

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
     * @return UserDetailsDTO
     */
    public function userAction(Request $request)
    {
        return $this->userService->user($request->get('username'));
//        return new Response($user->getEmail(),Response::HTTP_OK,['content-type'=>'application/json']);
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
}
