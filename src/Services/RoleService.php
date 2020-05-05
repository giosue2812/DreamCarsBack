<?php


namespace App\Services;


use App\DTO\RoleDetailsDTO;
use App\Entity\Role;
use App\Repository\RoleRepository;
use Doctrine\ORM\EntityManagerInterface;

class RoleService
{
    /**
     * @var EntityManagerInterface $manager
     */
    private $manager;
    /**
     * @var RoleRepository $repository
     */
    private $repository;

    /**
     * RoleService constructor.
     * @param EntityManagerInterface $manager
     * @param RoleRepository $repository
     */
    public function __construct(EntityManagerInterface $manager, RoleRepository $repository)
    {
        $this->manager = $manager;
        $this->repository = $repository;
    }

    public function getRoles()
    {
        $roles = $this->repository->findAll();
        /**
         * Array empty to stock each groupe
         */
        $arrayRole = [];
        foreach ($roles as $role)
        {
            /**
             * New DTO map Groupe
             */
            $DTO = new RoleDetailsDTO($role);
            $arrayRole[]=$DTO;
        }
        return $arrayRole;
    }
}
