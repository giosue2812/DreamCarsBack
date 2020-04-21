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
     * @return \DateTime
     */
    public function getCreateAt(): \DateTime
    {
        return $this->createAt;
    }


    /**
     * @return \DateTime
     */
    public function getUpdateAt(): \DateTime
    {
        return $this->updateAt;
    }



    /**
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->firstName;
    }


    /**
     * @return string
     */
    public function getLastName(): string
    {
        return $this->lastName;
    }



    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }



    /**
     * @return string
     */
    public function getPhone(): string
    {
        return $this->phone;
    }



    /**
     * @return string
     */
    public function getStreet(): string
    {
        return $this->street;
    }



    /**
     * @return string
     */
    public function getNumber(): string
    {
        return $this->number;
    }



    /**
     * @return string
     */
    public function getPostalCode(): string
    {
        return $this->postalCode;
    }



    /**
     * @return string
     */
    public function getCountry(): string
    {
        return $this->country;
    }


    /**
     * @return Groupe[]|null
     */
    public function getGroupe(): array
    {
        return $this->groupe;
    }

    /**
     * @return UserRole[]
     */
    public function getUserRoles(): array
    {
        return $this->userRoles;
    }

}
