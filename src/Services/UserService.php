<?php


namespace App\Services;


use App\DTO\UserDetailsDTO;
use App\Entity\User;
use App\Models\Forms\UserForm;
use App\Repository\UserRepository;
use App\Utils\MapperAuto;
use AutoMapperPlus\Exception\UnregisteredMappingException;
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

        $this->manager->persist($user);
        $this->manager->flush();
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
}
