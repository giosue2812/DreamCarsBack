<?php


namespace App\DTO;

use App\Entity\Groupe;
use App\Entity\User;
use App\Entity\UserRole;
use JMS\Serializer\Annotation as Serializer;

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
     * @var string $first_name
     * @Serializer\SerializedName("firstName")
     */
    private $first_name;
    /**
     * @var string $last_name
     * @Serializer\SerializedName("lastName")
     */
    private $last_name;
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
     * @var string $postal_code
     * @Serializer\SerializedName("postalCode")
     */
    private $postal_code;
    /**
     * @var string $city
     */
    private $city;
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

    /**
     * UserDetailsDTO constructor.
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->id = $user->getId();
        $this->createAt = $user->getCreateAt();
        $this->updateAt = $user->getUpdateAt();
        $this->first_name = $user->getFirstName();
        $this->last_name = $user->getLastName();
        $this->email = $user->getEmail();
        $this->phone = $user->getPhone();
        $this->street = $user->getStreet();
        $this->number = $user->getNumber();
        $this->city = $user->getCity();
        $this->postal_code = $user->getPostalCode();
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
        return $this->first_name;
    }


    /**
     * @return string
     */
    public function getLastName(): string
    {
        return $this->last_name;
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
        return $this->postal_code;
    }

    /**
     * @return string
     */
    public function getCity(): string
    {
        return $this->city;
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
