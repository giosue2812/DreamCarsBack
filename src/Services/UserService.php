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
use Symfony\Component\Config\Definition\Exception\Exception;
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
     * @return User if User != null
     * @throws Exception if PDOException is rise
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
            throw new Exception('Unexpected Error',500);
        }
        return $user;
    }

    /**
     * @param string $username
     * @return User if User != null
     * @throws Exception if User == null
     * UserName => email
     */
    public function getUserByUserName($username)
    {
        $user =  $this->userRepository->findOneBy(['email' => $username]);
        if($user)
        {
            return $user;
        }
        else
        {
            throw new Exception('User not found',404);
        }
    }

    /**
     * @param UserFormUpdate $userFormUpdate
     * @param $userId
     * @return User if User != null
     * @throws Exception if User == null
     */
    public function update(UserFormUpdate $userFormUpdate,$userId)
    {
        $userToUpdate = $this->getUserById($userId);
        if($userToUpdate)
        {
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
                throw new Exception('Unexpected error',500);
            }
            return $userToUpdate;
        }
        else
        {
            throw new Exception('User not found',404);
        }
    }

    /**
     * @param string $keyWord
     * @return array if array.lenght > 0
     * @throws Exception if array.lenght <= 0
     */
    public function searchUser(string $keyWord)
    {
        $user = $this->userRepository->searchUser($keyWord);
        if($user)
        {
            return $user;
        }
        else
        {
            throw new Exception('User No found',404);
        }
    }

    /**
     * @param $userId
     * @param GroupeForm $groupeForms
     * @return User if User and Groupe != null
     * @throws Exception if User and Groupe == null || PDOException is Rise
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
        if ($user && $groupe)
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
                throw new Exception('Unexpected Error',500);
            }
        }
        else
        {
            throw new Exception('User or Groupe not found',404);
        }
        return $user;
    }

    /**
     * @param $userId
     * @param RoleForm $roleForm
     * @return UserRole if user && role != null && UserRole == null
     * @throws \Exception if user && role == null || UserRole != null
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
        if($user)
        {
            /**
             * then we call the userservice to found the userRole with param user and param role
             */
            $userRole = $this->userRoleService->findUserRoleByRoleAndUser($user->getId(),$role->getId());
            /**
             * if userrole exist and the userrole is not null
             */
            if($userRole && $userRole != null && $userRole->getEndDate() == null)
            {
                throw new Exception('Role and User has already in relation',404);
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
                } catch (PDOException $e)
                {
                    throw new Exception('Unexpected Error',500);
                }
            }
        }
        /**
         * If role and user is not known
         */
        else
        {
            throw new Exception('User is unknonw',404);
        }
        return $userRole;
    }

    /**
     * @param int $userId
     * @param string $groupe
     * @return User if getUserById == true and getGroupe == true
     * @throws PDOException is Rise
     */
    public function removeGroupe(int $userId, string $groupe)
    {
        /**
         * I get the user and groupe selected
         */
        $user = $this->getUserById($userId);
        $groupe = $this->groupeService->getGroupe($groupe);
            /**
             * Try to remove group
             */
            try {
                $user->removeGroup($groupe);
                $this->manager->flush();
                return $user;
            } catch (PDOException $e)
            {
                /**
                 * Send a Json response if there is an issue
                 */
                throw new Exception('Unexpected Error',500);
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
        return new JsonResponseDTO('200','success',new UserDetailsDTO($userRole->getUsers()));
    }

    /**
     * @param $id
     * @return User if User == true
     * @throws Exception if User == false
     */
    public function getUser($id)
    {
        $user = $this->userRepository->find($id);
        if($user)
        {
            return $user;
        }
        else
        {
            throw new Exception('User not found',404);
        }
    }

    /**
     * @param $id
     * @return User if User == true
     * @throws User if User == false
     */
    private function getUserById($id)
    {
        $user = $this->userRepository->find($id);
        if($user)
        {
            return $user;
        }
        else
        {
            throw new Exception('User not found',404);
        }
    }
}
