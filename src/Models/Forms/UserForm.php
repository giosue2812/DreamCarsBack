<?php


namespace App\Models\Forms;


use Symfony\Component\Validator\Constraints as Assert;

class UserForm
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
     * @var string $password
     */
    private $password;
    /**
     * @var string $passwordConfirm
     */
    private $passwordConfirm;
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
     * @return mixed
     */
    public function getLastName(): ?string
    {
        return $this->lastName;
    }


    /**
     * @return mixed
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }


    /**
     * @return string
     */
    public function getPasswordConfirm(): ?string
    {
        return $this->passwordConfirm;
    }


    /**
     * @return string
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }


    /**
     * @return string
     */
    public function getStreet(): ?string
    {
        return $this->street;
    }


    /**
     * @return string
     */
    public function getNumber(): ?string
    {
        return $this->number;
    }


    /**
     * @return string
     */
    public function getPostalCode(): ?string
    {
        return $this->postalCode;
    }


    /**
     * @return string
     */
    public function getCity(): ?string
    {
        return $this->city;
    }

    /**
     * @return string
     */
    public function getCountry(): ?string
    {
        return $this->country;
    }

    /**
     * @return string
     */
    public function getPhone(): ?string
    {
        return $this->phone;
    }

}
