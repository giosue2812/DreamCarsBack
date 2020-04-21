<?php

namespace App\Controller;

use App\DTO\UserDetailsDTO;
use App\Entity\User;
use App\Form\UserType;
use App\Models\Forms\UserForm;
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
        return 'ok';
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
    }
}
