<?php


namespace App\DTO;

use App\Entity\Groupe;
use App\Entity\User;
use App\Entity\UserRole;
use JMS\Serializer\Annotation as Serializer;
use OpenApi\Annotations as OA;

/**
 * Class UserDetailsDTO
 * @package App\DTO
 * @OA\Schema(
 *     description="User model",
 *     type="object",
 *     title="User model"
 * )
 */

class UserDetailsDTO
{
    /**
     * @OA\Property(
     *     property="id",
     *     type="integer",
     *     description="Id of user"
     * )
     * @var integer $id
     */
    private $id;
    /**
     * @OA\Property(
     *     property="createAt",
     *     type="string",
     *     format="date",
     *     description="Date of creation user"
     * )
     * @var \DateTime $createAt
     */
    private $createAt;
    /**
     * @OA\Property(
     *     property="updateAt",
     *     type="string",
     *     format="date",
     *     description="Date of update user"
     * )
     * @var \DateTime $updateAt
     */
    private $updateAt;
    /**
     * @OA\Property(
     *     property="first_name",
     *     type="string",
     *     description="First name of user"
     * )
     * @var string $first_name
     * @Serializer\SerializedName("firstName")
     */
    private $first_name;
    /**
     * @OA\Property(
     *     property="last_name",
     *     type="string",
     *     description="Last name of user"
     * )
     * @var string $last_name
     * @Serializer\SerializedName("lastName")
     */
    private $last_name;
    /**
     * @OA\Property(
     *     property="email",
     *     type="string",
     *     description="Email for user. Unique identifier"
     * )
     * @var string $email
     */
    private $email;
    /**
     * @OA\Property(
     *     property="phone",
     *     type="string",
     *     description="Phone number of user"
     * )
     * @var string $phone
     */
    private $phone;
    /**
     * @OA\Property(
     *     property="street",
     *     type="string",
     *     description="Address street of user"
     * )
     * @var string $street
     */
    private $street;
    /**
     * @OA\Property(
     *     property="number",
     *     type="string",
     *     description="Address number of user"
     * )
     * @var string $number
     */
    private $number;
    /**
     * @OA\Property(
     *     property="postal_code",
     *     type="string",
     *     description="Address postal code of user"
     * )
     * @var string $postal_code
     * @Serializer\SerializedName("postalCode")
     */
    private $postal_code;
    /**
     * @OA\Property(
     *     property="city",
     *     type="string",
     *     description="Address city of user"
     * )
     * @var string $city
     */
    private $city;
    /**
     * @OA\Property(
     *     property="country",
     *     type="string",
     *     description="Address country of user"
     * )
     * @var string $country
     */
    private $country;
    /**
     * @OA\Property(
     *      property="groupe",
     *      ref="#/components/schemas/RoleDetailsDTO",
     *      type="object",
     *      description="User's groupe"
     * )
     * @var Groupe[] $groupe
     */
    private $groupe;
    /**
     * @OA\Property(
     *     property="userRoles",
     *     ref="#/components/schemas/UserRoleDetailsDTO",
     *     type="object",
     *     description="User's UserRole"
     * )
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
            return [$usr->getId(),$usr->getRoles()->getRole(),$usr->getStartDate(),$usr->getEndDate()];
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
