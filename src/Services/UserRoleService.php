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
     * @return UserRole|null
     */
    public function findUserRole($userRoleID)
    {
        return $this->repository->find($userRoleID);
    }

    /**
     * @return JsonResponseDTO
     */
    public function getUserRole()
    {
        $userRole = $this->repository->findAll();
        $arrayUserRole = [];
        foreach ($userRole as $item) {
            $DTO = new UserRoleDetailsDTO($item);
            $arrayUserRole[]=$DTO;
        }
        return new JsonResponseDTO('200','success',$DTO);
    }

}
