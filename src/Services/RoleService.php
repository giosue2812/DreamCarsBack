<?php


namespace App\Services;


use App\DTO\JsonResponseDTO;
use App\DTO\RoleDetailsDTO;
use App\Entity\Role;
use App\Models\Forms\RoleFormAdd;
use App\Repository\RoleRepository;
use Doctrine\DBAL\Driver\PDOException;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Config\Definition\Exception\Exception;
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
     * @return Role[] if role.lenght > 0
     * @throws \Exception if role.lenght <= 0
     */
    public function getRoles()
    {
        $roles = $this->repository->findAll();
        /**
         * Array empty to stock each groupe
         */
        if($roles == null)
        {
            /**
             * If roles is null
             */
            throw new \Exception("Not roles found in database");
        }
        return $roles;
    }

    /**
     * @param $id_role
     * @return Role|null if role != null
     * @throws \Exception if role == null
     */
    public function getRole($id_role)
    {
        /**
         * Find role if exist
         */
        $role = $this->repository->find($id_role);
        if(isset($role))
        {
            //Return a role. If role exist
            return $role;
        }
        else
        {
            throw new Exception('No found the role',404);
        }
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
     * @return Role[] if role.lenght > 0 else
     * @throws \Exception if \PDOException is rise ||
     *  Role.getRole == $roleFormAdd.getRole
     */
    public function addNewRole(RoleFormAdd $roleFormAdd)
    {
        $date = new \DateTime();
        $roleExist = $this->getRoleByName($roleFormAdd->getRole());
        if($roleExist && $roleExist->getDeleteAt() != null && $roleExist->getIsActive() == false){
            $roleExist->setIsActive(true);
            $roleExist->setDeleteAt(null);
            $roleExist->setUpdateAt($date);

            try {
                $this->manager->flush();
            } catch (PDOException $e)
            {
                throw new \Exception('Unexpected error',500);
            }
        }
        elseif ($roleExist && $roleExist->getDeleteAt() == null && $roleExist->getIsActive() == true )
        {
            throw new \Exception('The role exist in the database',404);
        }
        else {
            /**
             * New instance of role
             */
            $role = new Role();
            $role->setRole($roleFormAdd->getRole());
            try {
                $this->manager->persist($role);
                $this->manager->flush();
            } catch (PDOException $e) {
                throw new \Exception('Unexpected error',500);
            }
        }
        return $this->getRoles();
    }

    /**
     * @param $idRole
     * @param RoleFormAdd $roleFormAdd
     * @return Role[] if role.length > 0
     * @throws \Exception if \PDOException is rise ||
     *  role.lenght <= 0
     */
    public function updateRole($idRole,RoleFormAdd $roleFormAdd)
    {
        $date = new \DateTime();
        $role = $this->repository->find($idRole);
        if(isset($role))
        {
            $role->setRole($roleFormAdd->getRole());
            $role->setUpdateAt($date);
        }
        else
        {
            throw new \Exception('Role not found',404);
        }

        try {
            $this->manager->flush();
        } catch (PDOException $e)
        {
            throw new \Exception('Unexpected error',500);
        }
        return $this->getRoles();
    }

    /**
     * @param $idRole
     * @return Role[] if role.lenght > 0
     * @throws \Exception if role.lenght <= 0 ||
     * \PDOException is rise
     */
    public function removeRole($idRole)
    {
        $date = new \DateTime();
        $role = $this->getRole($idRole);
        if($role)
        {
            $role->setIsActive(false);
            $role->setDeleteAt($date);
            try {
                $this->manager->flush();
            } catch (PDOException $e)
            {
                throw new \Exception('Unexpected error',500);
            }
        }
        else
        {
            throw new \Exception('Role not found',404);
        }

        return $this->getRoles();
    }
}
