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

    public function __construct(EntityManagerInterface $manager, RoleRepository $repository)
    {
        $this->manager = $manager;
        $this->repository = $repository;
    }

    public function getRoles()
    {
        $roles = $this->repository->findAll();
        $arrayRole = [];
        foreach ($roles as $role)
        {
            $DTO = new RoleDetailsDTO($role);
            $arrayRole[]=$DTO;
        }
        return $arrayRole;
    }
}
