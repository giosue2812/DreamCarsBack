<?php


namespace App\Services;

use App\DTO\UserDetailsDTO;
use App\Entity\Groupe;
use App\Entity\User;
use App\Models\Forms\GroupeForms;
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
    private $manager;
    /**
     * @var UserRepository $userRepository
     */
    private $userRepository;
    /**
     * @var UserPasswordEncoderInterface $userPasswordEncode
     */
    private $userPasswordEncode;
    /**
     * @var GroupeRepository $groupeRepository
     */
    private $groupeRepository;
    /**
     * @var GroupeService $groupeService
     */
    private $groupeService;

    /**
     * UserService constructor.
     * @param EntityManagerInterface $manager
     * @param UserRepository $userRepository
     * @param UserPasswordEncoderInterface $userPasswordEncode
     * @param GroupeRepository $groupeRepository
     * @param GroupeService $groupeService
     */
    public function __construct(
        EntityManagerInterface $manager,
        UserRepository $userRepository,
        UserPasswordEncoderInterface $userPasswordEncode,
        GroupeRepository $groupeRepository,
        GroupeService $groupeService
    )
    {
        $this->manager = $manager;
        $this->userRepository = $userRepository;
        $this->userPasswordEncode = $userPasswordEncode;
        $this->groupeRepository = $groupeRepository;
        $this->groupeService = $groupeService;
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
    public function user($username)
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
        $userToUpdate = $this->getUserId($userId);
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
     * @param string $user
     * @return array
     */
    public function searchUser(string $user)
    {
        $user = $this->userRepository->searchUser($user);
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
     * @param GroupeForms $groupeForms
     * @return User
     */
    public function addGroupe($userId,GroupeForms $groupeForms)
    {
        /**
         * I get the userId from the route
         */
        $user = $this->getUserId($userId);
        /**
         * I get the groupe if exist
         */
        $groupe = $this->groupeService->getGroupe($groupeForms->getGroupe());

        /**
         * Add the group for the user
         */
        $user
            ->addGroup($groupe);
        /**
         * I try if the flush is done
         */
        try {
            $this->manager->flush();
        } catch (PDOException $e)
        {
            dump($e);
        }
        return $user;
    }

    /**
     * @param $id
     * @return User|null
     * Private function because is used only for now by the API
     */
    private function getUserId($id)
    {
        return $this->userRepository->find($id);
    }
}
