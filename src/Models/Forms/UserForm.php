<?php


namespace App\Models\Forms;


use Symfony\Component\Validator\Constraints as Assert;
use OpenApi\Annotations as OA;

/**
 * Class UserForm
 * @package App\Models\Forms
 * @OA\Schema(
 *     description="User Form model",
 *     type="object",
 *     title="User Form model"
 * )
 */
class UserForm
{
    /**
     * @OA\Property(
     *     property="firstName",
     *     type="string",
     *     description="First name of new user"
     * )
     * @Assert\NotNull()
     * @var string $first_name
     */
    private $first_name;
    /**
     * @OA\Property(
     *     property="lastName",
     *     type="string",
     *     description="Last name of new user"
     * )
     * @Assert\NotNull()
     * @var string $last_name
     */
    private $last_name;
    /**
     * @OA\Property(
     *     property="password",
     *     type="string",
     *     description="Password of new user"
     * )
     * @var string $password
     */
    private $password;
    /**
     * @OA\Property(
     *     property="passwordConfirm",
     *     type="string",
     *     description="passwordConfirm of new user"
     * )
     * @var string $passwordConfirm
     */
    private $passwordConfirm;
    /**
     * @OA\Property(
     *     property="email",
     *     type="string",
     *     description="Email of new user"
     * )
     * @var string $email
     * @Assert\Email()
     */
    private $email;
    /**
     * @OA\Property(
     *     property="street",
     *     type="string",
     *     description="Address street of new user"
     * )
     * @var string $street
     */
    private $street;
    /**
     * @OA\Property(
     *     property="number",
     *     type="string",
     *     description="Address number of new user"
     * )
     * @var string $number
     */
    private $number;
    /**
     * @OA\Property(
     *     property="postalCode",
     *     type="string",
     *     description="Address postal code of new user"
     * )
     * @var string $postal_code
     */
    private $postal_code;
    /**
     * @OA\Property(
     *     property="city",
     *     type="string",
     *     description="Address city of new user"
     * )
     * @var string $city
     */
    private $city;
    /**
     * @OA\Property(
     *     property="country",
     *     type="string",
     *     description="Address country of new user"
     * )
     * @var string $country
     */
    private $country;
    /**
     * @OA\Property(
     *     property="phone",
     *     type="string",
     *     description="Phone number of new user"
     * )
     * @var string $phone
     */
    private $phone;

    /**
     * @return string
     */
    public function getFirstName(): ?string
    {
        return $this->first_name;
    }

    /**
     * @param string $first_name
     * @return UserForm
     */
    public function setFirstName(string $first_name): UserForm
    {
        $this->first_name = $first_name;
        return $this;
    }

    /**
     * @return string
     */
    public function getLastName(): ?string
    {
        return $this->last_name;
    }

    /**
     * @param string $last_name
     * @return UserForm
     */
    public function setLastName(string $last_name): UserForm
    {
        $this->last_name = $last_name;
        return $this;
    }

    /**
     * @return string
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    /**
     * @param string $password
     * @return UserForm
     */
    public function setPassword(string $password): UserForm
    {
        $this->password = $password;
        return $this;
    }

    /**
     * @return string
     */
    public function getPasswordConfirm(): ?string
    {
        return $this->passwordConfirm;
    }

    /**
     * @param string $passwordConfirm
     * @return UserForm
     */
    public function setPasswordConfirm(string $passwordConfirm): UserForm
    {
        $this->passwordConfirm = $passwordConfirm;
        return $this;
    }

    /**
     * @return string
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param string $email
     * @return UserForm
     */
    public function setEmail(string $email): UserForm
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return string
     */
    public function getStreet(): ?string
    {
        return $this->street;
    }

    /**
     * @param string $street
     * @return UserForm
     */
    public function setStreet(string $street): UserForm
    {
        $this->street = $street;
        return $this;
    }

    /**
     * @return string
     */
    public function getNumber(): ?string
    {
        return $this->number;
    }

    /**
     * @param string $number
     * @return UserForm
     */
    public function setNumber(string $number): UserForm
    {
        $this->number = $number;
        return $this;
    }

    /**
     * @return string
     */
    public function getPostalCode(): ?string
    {
        return $this->postal_code;
    }

    /**
     * @param string $postal_code
     * @return UserForm
     */
    public function setPostalCode(string $postal_code): UserForm
    {
        $this->postal_code = $postal_code;
        return $this;
    }

    /**
     * @return string
     */
    public function getCity(): ?string
    {
        return $this->city;
    }

    /**
     * @param string $city
     * @return UserForm
     */
    public function setCity(string $city): UserForm
    {
        $this->city = $city;
        return $this;
    }

    /**
     * @return string
     */
    public function getCountry(): ?string
    {
        return $this->country;
    }

    /**
     * @param string $country
     * @return UserForm
     */
    public function setCountry(string $country): UserForm
    {
        $this->country = $country;
        return $this;
    }

    /**
     * @return string
     */
    public function getPhone(): ?string
    {
        return $this->phone;
    }

    /**
     * @param string $phone
     * @return UserForm
     */
    public function setPhone(string $phone): UserForm
    {
        $this->phone = $phone;
        return $this;
    }
}
