<?php


namespace App\Models\Forms;


use Symfony\Component\Validator\Constraints as Assert;
use OpenApi\Annotations as OA;

/**
 * Class UserFormUpdate
 * @package App\Models\Forms
 * @OA\Schema(
 *     description="User Form update",
 *     type="object",
 *     title="User Form Update model"
 * )
 */
class UserFormUpdate
{
    /**
     * @OA\Property(
     *     property="firstName",
     *     type="string",
     *     description="First name of update user"
     * )
     * @var string $first_name
     */
    private $first_name;
    /**
     * @OA\Property(
     *     property="lastName",
     *     type="string",
     *     description="Last name of update user"
     * )
     * @var string $last_name
     */
    private $last_name;
    /**
     * @OA\Property(
     *     property="email",
     *     type="string",
     *     description="Email of update user"
     * )
     * @var string $email
     * @Assert\Email()
     */
    private $email;
    /**
     * @OA\Property(
     *     property="street",
     *     type="string",
     *     description="Address of street to update user"
     * )
     * @var string $street
     */
    private $street;
    /**
     * @OA\Property(
     *     property="number",
     *     type="string",
     *     description="Address of number to update user"
     * )
     * @var string $number
     */
    private $number;
    /**
     * @OA\Property(
     *     property="postal_code",
     *     type="string",
     *     description="Address of postal code to update user"
     * )
     * @var string $postal_code
     */
    private $postal_code;
    /**
     * @OA\Property(
     *     property="city",
     *     type="string",
     *     description="Address of city to update user"
     * )
     * @var string $city
     */
    private $city;
    /**
     * @OA\Property(
     *     property="country",
     *     type="string",
     *     description="Address of country to update user"
     * )
     * @var string $country
     */
    private $country;
    /**
     * @OA\Property(
     *     property="phone",
     *     type="string",
     *     description="Phone number of update user"
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
     * @return UserFormUpdate
     */
    public function setFirstName(string $first_name): UserFormUpdate
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
     * @return UserFormUpdate
     */
    public function setLastName(string $last_name): UserFormUpdate
    {
        $this->last_name = $last_name;
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
     * @return UserFormUpdate
     */
    public function setEmail(string $email): UserFormUpdate
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
     * @return UserFormUpdate
     */
    public function setStreet(string $street): UserFormUpdate
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
     * @return UserFormUpdate
     */
    public function setNumber(string $number): UserFormUpdate
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
     * @return UserFormUpdate
     */
    public function setPostalCode(string $postal_code): UserFormUpdate
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
     * @return UserFormUpdate
     */
    public function setCity(string $city): UserFormUpdate
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
     * @return UserFormUpdate
     */
    public function setCountry(string $country): UserFormUpdate
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
     * @return UserFormUpdate
     */
    public function setPhone(string $phone): UserFormUpdate
    {
        $this->phone = $phone;
        return $this;
    }
}
