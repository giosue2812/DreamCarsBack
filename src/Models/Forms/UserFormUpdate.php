<?php


namespace App\Models\Forms;


use Symfony\Component\Validator\Constraints as Assert;

class UserFormUpdate
{
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
     * @Assert\Email()
     */
    private $email;
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
     * @var string $city
     */
    private $city;
    /**
     * @var string $country
     */
    private $country;
    /**
     * @var string $phone
     */
    private $phone;

    /**
     * @return string
     */
    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    /**
     * @param string $firstName
     * @return UserFormUpdate
     */
    public function setFirstName(string $firstName): UserFormUpdate
    {
        $this->firstName = $firstName;
        return $this;
    }

    /**
     * @return string
     */
    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    /**
     * @param string $lastName
     * @return UserFormUpdate
     */
    public function setLastName(string $lastName): UserFormUpdate
    {
        $this->lastName = $lastName;
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
        return $this->postalCode;
    }

    /**
     * @param string $postalCode
     * @return UserFormUpdate
     */
    public function setPostalCode(string $postalCode): UserFormUpdate
    {
        $this->postalCode = $postalCode;
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
