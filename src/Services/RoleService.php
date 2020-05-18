<?php


namespace App\Services;


use App\DTO\JsonResponseDTO;
use App\DTO\RoleDetailsDTO;
use App\Entity\Role;
use App\Models\Forms\RoleFormAdd;
use App\Repository\RoleRepository;
use Doctrine\DBAL\Driver\PDOException;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Constraints\Date;

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
     * @return JsonResponseDTO
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
        return new JsonResponseDTO('200','success',$arrayRole);
    }

    /**
     * @param $id_role
     * @return Role|null
     */
    public function getRole($id_role)
    {
        return $this->repository->find($id_role);
    }

    /**
     * @param $roleName
     * @return Role|null
     */
    public function getRoleByName($roleName)
    {
        return $this->repository->findOneBy(['role' => $roleName]);
    }

    /**
     * @param RoleFormAdd $roleFormAdd
     * @return JsonResponseDTO
     * @throws \Exception
     */
    public function addNewRole(RoleFormAdd $roleFormAdd)
    {
        $date = new \DateTime();
        $roleExist = $this->getRoleByName($roleFormAdd->getRole());
        if($roleExist){
            $roleExist->setIsActive(true);
            $roleExist->setDeleteAt(null);
            $roleExist->setUpdateAt($date);

            try {
                $this->manager->flush();
            } catch (PDOException $e)
            {
                dump($e);
            }
        }
        else {
            $role = new Role();
            $role->setRole($roleFormAdd->getRole());
            try {
                $this->manager->persist($role);
                $this->manager->flush();
            } catch (PDOException $e) {
                dump($e);
            }
        }
        return $this->getRoles();
    }

    /**
     * @param $idRole
     * @param RoleFormAdd $roleFormAdd
     * @return JsonResponseDTO
     * @throws \Exception
     */
    public function updateRole($idRole,RoleFormAdd $roleFormAdd)
    {
        $date = new \DateTime();
        $role = $this->repository->find($idRole);
        $role->setRole($roleFormAdd->getRole());
        $role->setUpdateAt($date);
        try {
            $this->manager->flush();
        } catch (PDOException $e)
        {
            dump($e);
        }
        $arrayRole = $this->getRoles();
        return $arrayRole;
    }

    /**
     * @param $idRole
     * @return JsonResponseDTO
     * @throws \Exception
     */
    public function removeRole($idRole)
    {
        $date = new \DateTime();
        $role = $this->getRole($idRole);
        $role->setIsActive(false);
        $role->setDeleteAt($date);
        try {
            $this->manager->flush();
        } catch (PDOException $e)
        {
            dump($e);
        }
        return $arrayRole = $this->getRoles();
    }
}
