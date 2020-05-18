<?php

namespace App\Controller;

use App\DTO\JsonResponseDTO;
use App\Form\GroupeType;
use App\Models\Forms\GroupeForm;
use App\Services\GroupeService;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;

class GroupeController extends AbstractFOSRestController
{
    /**
     * @var GroupeService $groupeService
     */
    private GroupeService $groupeService;

    /**
     * GroupeController constructor.
     * @param GroupeService $groupeService
     */
    public function __construct(GroupeService $groupeService)
    {
        $this->groupeService = $groupeService;
    }

    /**
     * @return JsonResponseDTO
     * @Rest\Get(path="/api/groupe")
     * @IsGranted("ROLE_ADMIN")
     * @Rest\View()
     */
    public function getGroupeAllAction()
    {
        return $this->groupeService->getGroupeAll();
    }

    /**
     * @Rest\Post(path="api/groupe/addGroupe")
     * @Rest\View()
     * @IsGranted("ROLE_ADMIN")
     * @param Request $request
     * @return JsonResponseDTO
     * @throws \Exception
     */
    public function addGroupeAction(Request $request)
    {
        $groupeForm = new GroupeForm();
        $data = json_decode($request->getContent(),true);
        $form = $this->createForm(GroupeType::class,$groupeForm,[
            'csrf_protection' => false
        ]);
        $form->submit($data);
        if($form->isSubmitted() && $form->isValid())
        {
            $groupe = $this->groupeService->addNewGroupe($form->getData());
        }
        return $groupe;
    }

    /**
     * @Rest\Put(path="api/groupe/updateGroupe/{idGroupe}")
     * @Rest\View()
     * @IsGranted("ROLE_ADMIN")
     * @param Request $request
     * @return JsonResponseDTO
     * @throws \Exception
     */
    public function updateGroupeAction(Request $request)
    {
        $groupeForm = new GroupeForm();
        $data = json_decode($request->getContent(),true);
        $form = $this->createForm(GroupeType::class,$groupeForm,[
            'csrf_protection' => false
        ]);
        $form->submit($data);
        if($form->isSubmitted() && $form->isValid())
        {
            $groupe = $this->groupeService->updateGroupe($request->get('idGroupe'),$form->getData());
        }
        return $groupe;
    }

    /**
     * @Rest\Delete(path="api/groupe/removeGroupe/{idGroupe}")
     * @Rest\View()
     * @param Request $request
     * @return JsonResponseDTO
     * @throws \Exception
     */
    public function removeGroupeAction(Request $request)
    {
        return $this->groupeService->removeGroupe($request->get('idGroupe'));
    }
}
