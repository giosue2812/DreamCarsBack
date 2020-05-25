<?php


namespace App\Services;


use App\DTO\JsonResponseDTO;
use App\DTO\UserDetailsDTO;
use App\DTO\UserRoleDetailsDTO;
use App\Entity\Role;
use App\Entity\User;
use App\Entity\UserRole;
use App\Repository\UserRoleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Validator\Constraints\Json;

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

    public function findUserRoleByRoleAndUser($userId,$roleId)
    {
        return $this->repository->findOneBy(['users'=>$userId,'roles'=>$roleId]);
    }
    /**
     * @param $userRoleID
     * @return UserRole if UserRole == false
     * @throws Exception if UserRole == true
     */
    public function findUserRole($userRoleID)
    {
        $userRole = $this->repository->find($userRoleID);
        if($userRole)
        {
            return $userRole;
        }
        else
        {
            throw new Exception('UserRole not found',404);
        }
    }

    /**
     * @return UserRole[] if array.lenght > 0
     * @throws Exception yf array.lenght <= 0
     */
    public function getUserRole()
    {
        $userRole = $this->repository->findAll();
        if($userRole)
        {
            return $userRole;
        }
        else
        {
            throw new Exception('UserRole not found',404);
        }
    }

}
