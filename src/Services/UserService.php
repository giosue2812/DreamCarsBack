<?php


namespace App\Services;


use App\DTO\UserDetailsDTO;
use App\Entity\User;
use App\Models\Forms\UserForm;
use App\Models\Forms\UserFormUpdate;
use App\Repository\UserRepository;
use App\Utils\MapperAuto;
use AutoMapperPlus\Exception\UnregisteredMappingException;
use Doctrine\DBAL\Driver\PDOException;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Flex\Response;

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

    public function __construct(
        EntityManagerInterface $manager,
        UserRepository $userRepository,
        UserPasswordEncoderInterface $userPasswordEncode
    )
    {
        $this->manager = $manager;
        $this->userRepository = $userRepository;
        $this->userPasswordEncode = $userPasswordEncode;
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
        $userToUpdate = $this->userRepository->find($userId);
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
}
