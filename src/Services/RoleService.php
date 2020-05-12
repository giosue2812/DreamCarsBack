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
    private EntityManagerInterface $manager;
    /**
     * @var RoleRepository $repository
     */
    private RoleRepository $repository;

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

    /**
     * @return array
     */
    public function getRoles()
    {
        $roles = $this->repository->findAll();
        /**
         * Array empty to stock each groupe
         */
        $arrayRole = [];
        foreach ($roles as $role) {
            /**
             * New DTO map Groupe
             */
            $DTO = new RoleDetailsDTO($role);
            $arrayRole[] = $DTO;
        }
        return $arrayRole;
    }

    /**
     * @param $id_role
     * @return Role|null
     */
    public function getRole($id_role)
    {
        return $this->repository->find($id_role);
    }

    public function getRoleByName($roleName)
    {
        return $this->repository->findOneBy(['role' => $roleName]);
    }
}
