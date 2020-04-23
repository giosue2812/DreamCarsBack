<?php

namespace App\Controller;

use App\DTO\GroupeDetailsDTO;
use App\Services\GroupeService;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Flex\Response;

class GroupeController extends AbstractFOSRestController
{
    /**
     * @var GroupeService $groupeService
     */
    private $groupeService;

    public function __construct(GroupeService $groupeService)
    {
        $this->groupeService = $groupeService;
    }

    /**
     * @return array
     * @Rest\Get(path="/api/groupe")
     * @Rest\View()
     */
    public function getGroupeAllAction()
    {
        return $this->groupeService->getGroupeAll();
    }
}
