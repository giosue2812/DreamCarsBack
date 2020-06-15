<?php


namespace App\DTO;


use App\Entity\Supplier;
use OpenApi\Annotations as OA;

/**
 * Class SuppliersDTO
 * @package App\DTO
 * @OA\Schema(
 *      description="Supplier Model",
 *      type="object",
 *      title="Supplier Model"
 * )
 */
class SuppliersDTO
{
    /**
     * @var integer $id
     * @OA\Property(
     *     property="id",
     *     type="integer",
     *     description="Product id"
     * )
     */
    private $id;
    /**
     * @var string $name
     * @OA\Property(
     *     property="name",
     *     type="string",
     *     description="Product Name"
     * )
     */
    private $name;
    /**
     * @var string $street
     * @OA\Property(
     *     property="street",
     *     type="string",
     *     description="Supplier street"
     * )
     */
    private $street;
    /**
     * @var integer $number
     * @OA\Property(
     *     property="number",
     *     type="integer",
     *     description="Supplier number"
     * )
     */
    private $number;
    /**
     * @var string $postal_code
     * @OA\Property(
     *     property="postal_code",
     *     type="string",
     *     description="Supplier postal_code"
     * )
     */
    private $postal_code;
    /**
     * @var string $tel
     * @OA\Property(
     *     property="tel",
     *     type="string",
     *     description="Supplier tel"
     * )
     */
    private $tel;
    /**
     * @var string $email
     * @OA\Property(
     *     property="email",
     *     type="string",
     *     description="Supplier Email"
     * )
     */
    private $email;
    /**
     * @var string $city
     * @OA\Property(
     *     property="city",
     *     type="string",
     *     description="Supplier city"
     * )
     */
    private $city;
    /**
     * @var string $country
     * @OA\Property(
     *     property="country",
     *     type="string",
     *     description="Supplier country"
     * )
     */
    private $country;
    /**
     * @var boolean $active
     * @OA\Property(
     *     property="active",
     *     type="boolean",
     *     description="Supplier is active"
     * )
     */
    private $active;

    public function __construct(Supplier $supplier)
    {
        $this->id = $supplier->getId();
        $this->name = $supplier->getName();
        $this->country = $supplier->getCountry();
        $this->city = $supplier->getCity();
        $this->postal_code = $supplier->getPostalCode();
        $this->street = $supplier->getStreet();
        $this->tel = $supplier->getTel();
        $this->number = $supplier->getNumber();
        $this->email = $supplier->getEmail();
        $this->active = $supplier->getIsActive();
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->active;
    }

    /**
     * @return string
     */
    public function getStreet(): string
    {
        return $this->street;
    }

    /**
     * @return int
     */
    public function getNumber(): int
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
    public function getTel(): string
    {
        return $this->tel;
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


}
