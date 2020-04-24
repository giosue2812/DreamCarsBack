<?php


namespace App\Services;


use App\DTO\GroupeDetailsDTO;
use App\Entity\Groupe;
use App\Repository\GroupeRepository;
use App\Repository\RoleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;

class GroupeService
{
    /**
     * @var GroupeRepository $repository
     */
    private $repository;
    /**
     * @var EntityManagerInterface $manager
     */
    private $manager;

    public function __construct(GroupeRepository $repository, EntityManagerInterface $manager)
    {
        $this->repository = $repository;
        $this->manager = $manager;
    }

    /**
     * @return array
     */
    public function getGroupeAll()
    {
        $groupes = $this->repository->findAll();
        /**
         * Array empty to stock each groupe
         */
        $arrayGroupe = [];
        foreach ($groupes as $groupe)
        {
            /**
             * New DTO to map Groupe
             */
            $DTO = new GroupeDetailsDTO($groupe);
            $arrayGroupe[]=$DTO;
        }
        return $arrayGroupe;
    }

}
