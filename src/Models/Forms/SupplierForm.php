<?php


namespace App\Models\Forms;


use Symfony\Component\Validator\Constraints as Assert;
use OpenApi\Annotations as OA;

/**
 * Class SupplierForm
 * @package App\Models\Forms
 * @OA\Schema(
 *     description="Supplier form model",
 *     type="object",
 *     title="Supplier form model"
 * )
 */
class SupplierForm
{
    /**
     * @var string $name
     * @Assert\NotBlank()
     * @Assert\NotNull()
     * @OA\Property(
     *     property="name",
     *     type="string",
     *     description="Name of supplier"
     * )
     */
    private $name;
    /**
     * @var string $street
     * @Assert\NotBlank()
     * @Assert\NotNull()
     * @OA\Property(
     *     property="street",
     *     type="string",
     *     description="Street of supplier"
     * )
     */
    private $street;
    /**
     * @var string $number
     * @Assert\NotBlank()
     * @Assert\NotNull()
     * @OA\Property(
     *     property="number",
     *     type="string",
     *     description="Number of supplier"
     * )
     */
    private $number;
    /**
     * @var string $postalCode
     * @Assert\NotBlank()
     * @Assert\NotNull()
     * @OA\Property(
     *     property="postalCode",
     *     type="string",
     *     description="Postal code of supplier"
     * )
     */
    private $postalCode;
    /**
     * @var string $tel
     * @Assert\NotBlank()
     * @Assert\NotNull()
     * @OA\Property(
     *     property="tel",
     *     type="string",
     *     description="Tel of supplier"
     * )
     */
    private $tel;
    /**
     * @var string $email
     * @Assert\NotBlank()
     * @Assert\NotNull()
     * @Assert\Email()
     * @OA\Property(
     *     property="email",
     *     type="string",
     *     description="Email of supplier"
     * )
     */
    private $email;
    /**
     * @var string $city
     * @Assert\NotNull()
     * @Assert\NotBlank()
     * @OA\Property(
     *     property="city",
     *     type="string",
     *     description="City of supplier"
     * )
     */
    private $city;
    /**
     * @var string $country
     * @Assert\NotNull()
     * @Assert\NotBlank()
     * @OA\Property(
     *     property="country",
     *     type="string",
     *     description="Country of supplier"
     * )
     */
    private $country;

    /**
     * @return string
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return SupplierForm
     */
    public function setName(string $name): SupplierForm
    {
        $this->name = $name;
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
     * @return SupplierForm
     */
    public function setStreet(string $street): SupplierForm
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
     * @return SupplierForm
     */
    public function setNumber(string $number): SupplierForm
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
     * @return SupplierForm
     */
    public function setPostalCode(string $postalCode): SupplierForm
    {
        $this->postalCode = $postalCode;
        return $this;
    }

    /**
     * @return string
     */
    public function getTel(): ?string
    {
        return $this->tel;
    }

    /**
     * @param string $tel
     * @return SupplierForm
     */
    public function setTel(string $tel): SupplierForm
    {
        $this->tel = $tel;
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
     * @return SupplierForm
     */
    public function setEmail(string $email): SupplierForm
    {
        $this->email = $email;
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
     * @return SupplierForm
     */
    public function setCity(string $city): SupplierForm
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
     * @return SupplierForm
     */
    public function setCountry(string $country): SupplierForm
    {
        $this->country = $country;
        return $this;
    }

}
