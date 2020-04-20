<?php


namespace App\DTO;

use App\Entity\Groupe;
use App\Entity\User;
use App\Entity\UserRole;

class UserDetailsDTO
{
    /**
     * @var integer $id
     */
    private $id;
    /**
     * @var \DateTime $createAt
     */
    private $createAt;
    /**
     * @var \DateTime $updateAt
     */
    private $updateAt;
    /**
     * @var string $firstName
     */
    private $firstName;
    /**
     * @var string $lastName
     */
    private $lastName;
    /**
     * @var string $email
     */
    private $email;
    /**
     * @var string $phone
     */
    private $phone;
    /**
     * @var string $street
     */
    private $street;
    /**
     * @var string $number
     */
    private $number;
    /**
     * @var string $postalCode
     */
    private $postalCode;
    /**
     * @var string $country
     */
    private $country;
    /**
     * @var Groupe[] $groupe
     */
    private $groupe;
    /**
     * @var UserRole[] $userRoles
     */
    private $userRoles;

    public function __construct(User $user)
    {
        $this->id = $user->getId();
        $this->createAt = $user->getCreateAt();
        $this->updateAt = $user->getUpdateAt();
        $this->firstName = $user->getFirstName();
        $this->lastName = $user->getLastName();
        $this->email = $user->getEmail();
        $this->phone = $user->getPhone();
        $this->street = $user->getStreet();
        $this->number = $user->getNumber();
        $this->postalCode = $user->getPostalCode();
        $this->country = $user->getCountry();

        $this->groupe = array_map(function ($gr){
            /** @var Groupe $gr */
            return $gr->getGroupe();
        },$user->getGroups()->getValues());

        $this->userRoles = array_map(function($usr){
            /** @var UserRole $usr */
            return array($usr->getRoles()->getRole(),$usr->getStartDate(),$usr->getEndDate());
        },$user->getUserRoles()->getValues());
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return UserDetailsDTO
     */
    public function setId(int $id): UserDetailsDTO
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getCreateAt(): \DateTime
    {
        return $this->createAt;
    }

    /**
     * @param \DateTime $createAt
     * @return UserDetailsDTO
     */
    public function setCreateAt(\DateTime $createAt): UserDetailsDTO
    {
        $this->createAt = $createAt;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getUpdateAt(): \DateTime
    {
        return $this->updateAt;
    }

    /**
     * @param \DateTime $updateAt
     * @return UserDetailsDTO
     */
    public function setUpdateAt(\DateTime $updateAt): UserDetailsDTO
    {
        $this->updateAt = $updateAt;
        return $this;
    }

    /**
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->firstName;
    }

    /**
     * @param string $firstName
     * @return UserDetailsDTO
     */
    public function setFirstName(string $firstName): UserDetailsDTO
    {
        $this->firstName = $firstName;
        return $this;
    }

    /**
     * @return string
     */
    public function getLastName(): string
    {
        return $this->lastName;
    }

    /**
     * @param string $lastName
     * @return UserDetailsDTO
     */
    public function setLastName(string $lastName): UserDetailsDTO
    {
        $this->lastName = $lastName;
        return $this;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     * @return UserDetailsDTO
     */
    public function setEmail(string $email): UserDetailsDTO
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return string
     */
    public function getPhone(): string
    {
        return $this->phone;
    }

    /**
     * @param string $phone
     * @return UserDetailsDTO
     */
    public function setPhone(string $phone): UserDetailsDTO
    {
        $this->phone = $phone;
        return $this;
    }

    /**
     * @return string
     */
    public function getStreet(): string
    {
        return $this->street;
    }

    /**
     * @param string $street
     * @return UserDetailsDTO
     */
    public function setStreet(string $street): UserDetailsDTO
    {
        $this->street = $street;
        return $this;
    }

    /**
     * @return string
     */
    public function getNumber(): string
    {
        return $this->number;
    }

    /**
     * @param string $number
     * @return UserDetailsDTO
     */
    public function setNumber(string $number): UserDetailsDTO
    {
        $this->number = $number;
        return $this;
    }

    /**
     * @return string
     */
    public function getPostalCode(): string
    {
        return $this->postalCode;
    }

    /**
     * @param string $postalCode
     * @return UserDetailsDTO
     */
    public function setPostalCode(string $postalCode): UserDetailsDTO
    {
        $this->postalCode = $postalCode;
        return $this;
    }

    /**
     * @return string
     */
    public function getCountry(): string
    {
        return $this->country;
    }

    /**
     * @param string $country
     * @return UserDetailsDTO
     */
    public function setCountry(string $country): UserDetailsDTO
    {
        $this->country = $country;
        return $this;
    }

    /**
     * @return Groupe[]|null
     */
    public function getGroupe(): array
    {
        return $this->groupe;
    }

    /**
     * @param Groupe[] $groupe
     * @return UserDetailsDTO
     */
    public function setGroupe(array $groupe): UserDetailsDTO
    {
        $this->groupe = $groupe;
        return $this;
    }

    /**
     * @return UserRole[]
     */
    public function getUserRoles(): array
    {
        return $this->userRoles;
    }

    /**
     * @param UserRole[] $userRoles
     * @return UserDetailsDTO
     */
    public function setUserRoles(array $userRoles): UserDetailsDTO
    {
        $this->userRoles = $userRoles;
        return $this;
    }

}
