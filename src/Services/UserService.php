<?php


namespace App\Services;

use App\DTO\JsonResponseDTO;
use App\DTO\UserDetailsDTO;
use App\Entity\User;
use App\Entity\UserRole;
use App\Models\Forms\GroupeForm;
use App\Models\Forms\RoleForm;
use App\Models\Forms\UserForm;
use App\Models\Forms\UserFormUpdate;
use App\Repository\GroupeRepository;
use App\Repository\UserRepository;
use Doctrine\DBAL\Driver\PDOException;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserService
{
    /**
     * @var EntityManagerInterface $manager
     */
    private EntityManagerInterface $manager;
    /**
     * @var UserRepository $userRepository
     */
    private UserRepository $userRepository;
    /**
     * @var UserPasswordEncoderInterface $userPasswordEncode
     */
    private UserPasswordEncoderInterface $userPasswordEncode;
    /**
     * @var GroupeRepository $groupeRepository
     */
    private GroupeRepository $groupeRepository;
    /**
     * @var GroupeService $groupeService
     */
    private GroupeService $groupeService;
    /**
     * @var RoleService $roleService
     */
    private RoleService $roleService;
    /**
     * @var UserRoleService $userRoleService
     */
    private UserRoleService $userRoleService;

    /**
     * UserService constructor.
     * @param EntityManagerInterface $manager
     * @param UserRepository $userRepository
     * @param UserPasswordEncoderInterface $userPasswordEncode
     * @param GroupeRepository $groupeRepository
     * @param GroupeService $groupeService
     * @param RoleService $roleService
     * @param UserRoleService $userRoleService
     */
    public function __construct(
        EntityManagerInterface $manager,
        UserRepository $userRepository,
        UserPasswordEncoderInterface $userPasswordEncode,
        GroupeRepository $groupeRepository,
        GroupeService $groupeService,
        RoleService $roleService,
        UserRoleService $userRoleService
    )
    {
        $this->manager = $manager;
        $this->userRepository = $userRepository;
        $this->userPasswordEncode = $userPasswordEncode;
        $this->groupeRepository = $groupeRepository;
        $this->groupeService = $groupeService;
        $this->roleService = $roleService;
        $this->userRoleService = $userRoleService;
    }

    /**
     * @param UserForm $userForm
     * @return User
     */
    public function create(UserForm $userForm)
    {
        $user = new User();
        $user->setFirstName($userForm->getFirstName());
        $user->setLastName($userForm->getLastName());
        $user->setPassword($this->userPasswordEncode->encodePassword($user,$userForm->getPassword()));
        $user->setEmail($userForm->getEmail());
        $user->setPhone($userForm->getPhone());
        $user->setCountry($userForm->getCountry());
        $user->setStreet($userForm->getStreet());
        $user->setNumber($userForm->getNumber());
        $user->setPostalCode($userForm->getPostalCode());
        $user->setCity($userForm->getCity());

        /**
         * I try if the persist and flush is done. If not i receive message error
         */
        try {
            $this->manager->persist($user);
            $this->manager->flush();
        } catch (PDOException $e){
            dump($e);
        }
        return $user;
    }

    /**
     * @param string $username
     * @return UserDetailsDTO
     */
    public function getUserByUserName($username)
    {
        $user =  $this->userRepository->findOneBy(['email' => $username]);
        return new UserDetailsDTO($user);
    }

    /**
     * @param UserFormUpdate $userFormUpdate
     * @param $userId
     * @return User|null
     */
    public function update(UserFormUpdate $userFormUpdate,$userId)
    {
        $userToUpdate = $this->getUserById($userId);
        $userToUpdate
            ->setFirstName($userFormUpdate->getFirstName())
            ->setLastName($userFormUpdate->getLastName())
            ->setEmail($userFormUpdate->getEmail())
            ->setPhone($userFormUpdate->getPhone())
            ->setStreet($userFormUpdate->getStreet())
            ->setNumber($userFormUpdate->getNumber())
            ->setPostalCode($userFormUpdate->getPostalCode())
            ->setCity($userFormUpdate->getCity())
            ->setCountry($userFormUpdate->getCountry());
        /**
         * I try if the persist and flush is done. If not i receive message error
         */
        try {
            $this->manager->flush();
        } catch (PDOException $e) {
            dump($e);
        }
        return $userToUpdate;
    }

    /**
     * @param string $keyWord
     * @return array
     */
    public function searchUser(string $keyWord)
    {
        $user = $this->userRepository->searchUser($keyWord);
        /**
         * Array empty to stock each user
         */
        $arrayUser = [];
        foreach ($user as $item)
        {
            /**
             * New DTO to map user
             */
            $DTO = new UserDetailsDTO($item);
            $arrayUser[]=$DTO;
        }
        return $arrayUser;
    }

    /**
     * @param $userId
     * @param GroupeForm $groupeForms
     * @return JsonResponseDTO
     */
    public function addGroupe($userId, GroupeForm $groupeForms)
    {
        /**
         * I get the userId from the route
         */
        $user = $this->getUserById($userId);
        /**
         * I get the groupe if exist
         */
        $groupe = $this->groupeService->getGroupe($groupeForms->getGroupe());
        /**
         * If the role and user exist
         */
        if (isset($user) && isset($groupe))
        {
            /**
             * then we call the userservice to found the userRole with param user and param role
             * Add the group for the user
             */
            $user->addGroup($groupe);
            /**
             * I try if the flush is done
             */
            try {
                $this->manager->flush();
            } catch (PDOException $e)
            {
                return new JsonResponseDTO('500','Server Error',$e);
            }
        }
        return new JsonResponseDTO('200','Success',"L'utilisate ".$user->getEmail()." appartien au groupe ".$groupe->getGroupe());
    }

    /**
     * @param $userId
     * @param RoleForm $roleForm
     * @return JsonResponseDTO
     * @throws \Exception
     */
    public function addRole($userId,RoleForm $roleForm)
    {
        /**
         * New date instance
         */
        $date = new \DateTime();
        /**
         * We get the userId
         */
        $user = $this->getUserById($userId);
        $role = $this->roleService->getRole($roleForm->getIdRole());
        /**
         * If the role and user exist
         */
        if(isset($role)&&isset($user))
        {
            /**
             * then we call the userservice to found the userRole with param user and param role
             */
            $userRole = $this->userRoleService->findUserRoleByRoleAndUser($user->getId(),$role->getId());
            /**
             * if userrole exist and the userrole is not null
             */
            if(isset($userRole) && $userRole != null && $userRole->getEndDate() == null)
            {
                return new JsonResponseDTO('401','Failed','This role and this user is already present');
            }
            else
            {
                /**
                 * If userrole is not present. New instance Userrole is created.
                 */
                $userRole = new UserRole();
                /**
                 * Set users and set Roles
                 */
                $userRole->setUsers($user);
                $userRole->setRoles($role);
                $userRole->setStartDate($date);
                try {
                    /**
                     * Try if the persist is done
                     */
                    $this->manager->persist($userRole);
                    $this->manager->flush();
                    return new JsonResponseDTO('200','Succes',$user);
                } catch (PDOException $e)
                {
                    return new JsonResponseDTO('500','Server Error',$e);
                }
            }
        }
        /**
         * If role and user is not known
         */
        else
        {
            return new JsonResponseDTO('401','Failed','Role our User is unknonw');
        }
    }

    /**
     * @param int $userId
     * @param string $groupe
     * @return JsonResponseDTO
     */
    public function removeGroupe(int $userId, string $groupe)
    {
        /**
         * I get the user and groupe selected
         */
        $user = $this->getUserById($userId);
        $groupe = $this->groupeService->getGroupe($groupe);
        /**
         * If user and role exist
         */
        if(isset($user) && isset($groupe))
        {
            /**
             * Try to remove group
             */
            try {
                $user->removeGroup($groupe);
                $this->manager->flush();
            } catch (PDOException $e)
            {
                /**
                 * Send a Json response if there is an issue
                 */
                return new JsonResponseDTO('500','Server Error',$e);
            }
            /**
             * If success we send a 200 success
             */
            return new JsonResponseDTO('200','Success',"The groupe ". $groupe->getGroupe() . " has been removed");
        }
        else
        {
            /**
             * If the user or role is not present in the data base
             */
            return new JsonResponseDTO('400','Failed','User or groupe is unknown');
        }
    }

    /**
     * @param int $userRoleId
     * @return JsonResponseDTO
     * @throws \Exception
     */
    public function removeUserRole(int $userRoleId){
        /**
         * New Instance date
         */
        $date = new \DateTime();
        $userRole = $this->userRoleService->findUserRole($userRoleId);
        if(isset($userRole))
            {
                /**
                 * I set the end date to
                 */
                $userRole->setEndDate($date);
                /**
                 * Try to flush in the database
                 */
                try {
                    $this->manager->flush();
                } catch (PDOException $e)
                {
                    return new JsonResponseDTO('500','Server Error',$e);
                }
            }
            else
            {
                return new JsonResponseDTO('400','Failed','UserRole is unknown');
            }
        return new JsonResponseDTO('200','success','The role '.$userRole->getRoles()->getRole().' for username '.$userRole->getUsers()->getEmail().' has been removed');
    }
    /**
     * @param $id
     * @return User|null
     * Private function because is used only for now by the API
     */
    private function getUserById($id)
    {
        return $this->userRepository->find($id);
    }
}
