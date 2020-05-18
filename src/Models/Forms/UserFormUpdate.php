<?php


namespace App\Models\Forms;


use Symfony\Component\Validator\Constraints as Assert;

class UserFormUpdate
{
    /**
     * @var string $first_name
     */
    private $first_name;
    /**
     * @var string $last_name
     */
    private $last_name;
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
     * @var string $postal_code
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
