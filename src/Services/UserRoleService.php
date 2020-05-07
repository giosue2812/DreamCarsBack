<?php


namespace App\Services;


use App\Entity\Role;
use App\Entity\User;
use App\Entity\UserRole;
use App\Repository\UserRoleRepository;
use Doctrine\ORM\EntityManagerInterface;

class UserRoleService
{
    /**
     * @var EntityManagerInterface $manager
     */
    private EntityManagerInterface $manager;
    /**
     * @var UserRoleRepository $repository
     */
    private UserRoleRepository $repository;

    /**
     * UserRoleService constructor.
     * @param EntityManagerInterface $manager
     * @param UserRoleRepository $repository
     */
    public function __construct(EntityManagerInterface $manager, UserRoleRepository $repository)
    {
        $this->manager = $manager;
        $this->repository = $repository;
    }

    /**
     * @param $userId
     * @param $roleId
     * @return UserRole|null
     */
    public function findUserRole($userId,$roleId)
    {
        return $this->repository->findOneBy(['users'=>$userId,'roles'=>$roleId]);
    }

}
