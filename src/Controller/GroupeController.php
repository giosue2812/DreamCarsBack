<?php

namespace App\Controller;

use App\Services\GroupeService;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

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
     * @return array
     * @Rest\Get(path="/api/groupe")
     * @Rest\View()
     * @IsGranted("ROLE_ADMIN")
     */
    public function getGroupeAllAction()
    {
        return $this->groupeService->getGroupeAll();
    }
}
